<?php
require_once "pdo.php";

$failure = false;
$success = false;

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
elseif ( isset($_POST['logout']) ) {
  header('Location: index.php');
  return;
}
elseif (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
  if(! is_numeric ($_POST['mileage']) || ! is_numeric($_POST['year'])) {
    $failure = "Mileage and year must be numeric";
  } elseif(strlen($_POST['make'])<1) {
    $failure = "Make is required";
}
else {
  $sql="INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)";
  echo "<pre>\n".$sql."\n </pre> \n";
  $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']
    ));
    $success= "Record inserted";
}
}
$stm=$pdo->query("Select * from autos");
?>

<html>
<head>
  <title> N Kishore Kumar </title>
</head>
<?php require_once "bootstrap.php"; ?>
<body>
  <div class="container">
  <h1> Tracking Autos for <?php echo $_GET['name']; ?> </h1>
  <?php
  if ( $failure !== false ) {
      // Look closely at the use of single and double quotes
      echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
  }
  if ( $success !== false ) {
      // Look closely at the use of single and double quotes
      echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
  }
  ?>
  <form method="post">
    <p>Make:
    <input type="text" name="make" size="60"></p>
    <p>Year:
    <input type="text" name="year"></p>
    <p>Mileage:
    <input type="text" name="mileage"></p>
    <input type="submit" value="Add">
    <input type="submit" name="logout" value="Logout">
  </form>
<h2> Automobiles </h2>
<ul>
  <?php
  while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
    echo "<li>";
    echo htmlentities($row['year'])." ".htmlentities($row['make'])." / ".htmlentities($row['mileage']);
    echo "</li><br>";
  };
  ?>
</ul>
</div>
</body>
</html>

<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
if(isset($_POST['cancel'])) {
  header("Location: view.php");
  return;
}
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
  if(! is_numeric ($_POST['mileage']) || ! is_numeric($_POST['year'])) {
    $_SESSION['failure'] = "Mileage and year must be numeric";
    header("Location:add.php");
    return;
  } elseif(strlen($_POST['make'])<1) {
    $_SESSION['failure']= "Make is required";
    header("Location:add.php");
    return;
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

    $_SESSION['success']= "Record inserted";
    header("Location: view.php");
    return;
  }
}
?>
<html>
<head>
  <title> N Kishore Kumar </title>
</head>
<?php require_once "bootstrap.php"; ?>
<body>
  <div class="container">
  <h1> Tracking Autos for <?php echo $_SESSION['name']; ?> </h1>
  <?php
  if(isset($_SESSION['failure'])) {
    echo '<p style = "color:red"> '.htmlentities($_SESSION['failure'])."</p>\n";
    unset($_SESSION['error']);
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
    <input type="submit" name="cancel" value="Cancel">
  </form>
</div>
</body>
</html>

<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
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
  <h1> Tracking Autos for <?php echo $_SESSION['name']; ?> </h1>
  <?php
  if(isset($_SESSION['success'])) {
    echo '<p style = "color:green"> '.htmlentities($_SESSION['success'])."</p>\n";
    unset($_SESSION['error']);
  }
  ?>
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
  <p><a href="add.php"> Add New </a> | <a href="logout.php"> Logout </a></p>
  </div>
</body>
</html>

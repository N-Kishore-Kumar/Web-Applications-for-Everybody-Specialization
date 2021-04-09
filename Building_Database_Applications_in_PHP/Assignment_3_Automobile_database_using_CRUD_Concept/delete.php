<?php
require_once "pdo.php";
session_start();
if(isset($_POST['autos_id']) && isset($_POST['delete'])) {
  $sql = "DELETE FROM autos WHERE autos_id = :zip";
//  echo "<pre>\n".$sql."\n</pre>\n";
  $stmt=$pdo->prepare($sql);
  $stmt->execute(array(
    ':zip'=>$_POST['autos_id']
  ));
  $_SESSION['success']="Record Deleted";
  header('Location:index.php');
  return;
}
if (! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}
$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :xyz");
$stmt -> execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row===false) {
  $_SESSION['error'] = "Bad value for user id";
  header('Location:index.php');
  return;
}
?>
<html>
<head>
  <title> N Kishore Kumar </title>
</head>
<body>
    <p> Confirm: Deleting <?=htmlentities($row['make'])?> </p>
    <form method="post">
      <input type="hidden" name="autos_id" value="<?=htmlentities($row['autos_id'])?>">
    <p><input type="submit" value="Delete" name="delete"/></p>
    <p><a href="index.php">Cancel</a></p>
  </form>
</body>
</html>

<?php
require_once "pdo.php";
session_start();
if(isset($_POST['cancel'])) {
  header("Location:index.php");
  return;
}
if(isset($_POST['profile_id']) && isset($_POST['delete'])) {
  $sql = "DELETE FROM profile WHERE profile_id = :zip";
//  echo "<pre>\n".$sql."\n</pre>\n";
  $stmt=$pdo->prepare($sql);
  $stmt->execute(array(
    ':zip'=>$_POST['profile_id']
  ));
  $_SESSION['success']="Record Deleted";
  header('Location:index.php');
  return;
}
if (! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}
$stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
$stmt -> execute(array(":xyz" => $_GET['profile_id']));
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
<?php require_once "bootstrap.php"; ?>
<body>
  <div class="container">
    <h1> Deleting Profile </h1>
    <p> First Name: <?=htmlentities($row['first_name'])?></p>
    <p> Last Name: <?=htmlentities($row['last_name'])?></p>
    <form method="post">
      <input type="hidden" name="profile_id" value="<?=htmlentities($row['profile_id'])?>">
    <p><input type="submit" value="Delete" name="delete"/>
    <input type="submit" value="Cancel" name="cancel"/></p>
  </form>
</body>
</html>

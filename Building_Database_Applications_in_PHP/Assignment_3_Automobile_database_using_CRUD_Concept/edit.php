<?php
require_once "pdo.php";
session_start();
if(! isset($_SESSION['email'])) {
  die("ACCESS DENIED");
}
if(isset($_POST['cancel'])) {
  header("Location:index.php");
  return;
}

if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id'])) {

    // Data validation
    if(strlen($_POST['make'])<1 || strlen($_POST['model'])<1 ||strlen($_POST['year'])<1 ||strlen($_POST['mileage'])<1) {
      $_SESSION['error']= "All fields are required";
      header("Location:edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
      return;
    }
    else if(! is_numeric ($_POST['mileage'])) {
      $_SESSION['error'] = "Mileage must be numeric";
      header("Location:edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
      return;
    }
    else if(! is_numeric($_POST['year'])) {
      $_SESSION['error'] = "Year must be numeric";
      header("Location:edit.php?autos_id=" . htmlentities($_REQUEST['autos_id']));
      return;
    }
    else {
    $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year , mileage = :mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = "Record updated";
    header( 'Location: index.php' ) ;
    return;
  }
}

// Guardian: Make sure that user_id is present
if (! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern


//$n = htmlentities($row['name']);
//$e = htmlentities($row['email']);
//$p = htmlentities($row['password']);
//$user_id = $row['user_id'];
?>
<html>
<title> N Kishore Kumar </title>
<?php require_once "bootstrap.php"; ?>
<body>
  <div class="container">
    <h1> Editing Automobile</h1>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
    <p>Make:
    <input type="text" name="make" value="<?=htmlentities($row['make'])?>"></p>
    <p>Model:
    <input type="text" name="model" value="<?=htmlentities($row['model'])?>"></p>
    <p>Year:
    <input type="text" name="year" value="<?=htmlentities($row['year'])?>"></p>
    <p>Mileage:
    <input type="text" name="mileage" value="<?=htmlentities($row['mileage'])?>"></p>
    <input type="hidden" name="autos_id" value="<?=$row['autos_id']?>">
    <p><input type="submit" value="Save"/>
    <p><input type="submit" value="Cancel" name="cancel"/>
    </form>
  </div>
</body>
</html>

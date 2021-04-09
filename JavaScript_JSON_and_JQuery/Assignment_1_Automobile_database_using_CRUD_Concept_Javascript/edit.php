<?php
require_once "pdo.php";
session_start();
if(! isset($_SESSION['user_id'])) {
  die("ACCESS DENIED");
}
if(isset($_POST['cancel'])) {
  header("Location:index.php");
  return;
}

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {
  if(strlen($_POST['first_name'])<1 || strlen($_POST['last_name'])<1 ||strlen($_POST['email'])<1 ||strlen($_POST['headline'])<1 ||strlen($_POST['summary'])<1) {
    $_SESSION['error']= "All fields are required";
  header("Location: edit.php?profile_id=" . htmlentities($_POST["profile_id"]));
    return;
  }
  else if(strpos($_POST['email'],"@")===false) {
    $_SESSION['error'] = "Email address must contain @";
  header("Location: edit.php?profile_id=" . htmlentities($_POST["profile_id"]));
    return;
  }

    else {
    $sql = "UPDATE profile SET first_name = :fn,
            last_name = :ln, email = :em , headline = :he, summary = :su
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':fn' => $_POST['first_name'],
      ':ln' => $_POST['last_name'],
      ':em' => $_POST['email'],
      ':he' => $_POST['headline'],
      ':su' => $_POST['summary'],
      ':profile_id' => $_POST['profile_id'] ));
    $_SESSION['success'] = "Record updated";
    header( 'Location: index.php' ) ;
    return;
  }
}

// Guardian: Make sure that user_id is present
if (! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
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
    <h1> Editing Automobile for <?php echo $_SESSION['name'] ?></h1>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    ?>
    <form method="post" action="edit.php">
      <p>First Name:
      <input type="text" name="first_name" size="60"
      value="<?=htmlentities($row['first_name'])?>"
      /></p>
      <p>Last Name:
      <input type="text" name="last_name" size="60"
      value="<?=htmlentities($row['last_name'])?>"
      /></p>
      <p>Email:
      <input type="text" name="email" size="30"
      value="<?=htmlentities($row['email'])?>"
      /></p>
      <p>Headline:<br/>
      <input type="text" name="headline" size="80"
      value="<?=htmlentities($row['headline'])?>"
      /></p>
      <p>Summary:<br/>
      <textarea name="summary" rows="8" cols="80">
      <?=htmlentities($row['summary'])?></textarea>
      <p>
      <input type="hidden" name="profile_id" value="<?=$row['profile_id']?>" />
      <input type="submit" value="Save">
      <input type="submit" name="cancel" value="Cancel">
      </p>
      </form>

  </div>
</body>
</html>

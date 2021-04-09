<?php
session_start();
if(isset($_POST['cancel'])) {
  // Redirect the browser to index.php
  header("Location: index.php");
  return;
}
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

if(isset($_POST['email']) && isset($_POST['pass'])) {
  unset($_SESSION['name']);
  if(strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
    $_SESSION['error'] = "Email and password are required";
      header("Location: login.php");
      return;
  } elseif (strpos($_POST['email'] , "@") === false ) {
    $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;
  }
  else {
      $check = hash('md5', $salt.$_POST['pass']);
      if ( $check == $stored_hash ) {
          // Redirect the browser to view.php
          error_log("Login success ".$_POST['email']);
          $_SESSION['name']=$_POST['email'];
          header("Location: view.php");
          return;
      } else {
          error_log("Login fail ".$_POST['email']." $check");
          header("Location: login.php");
          $_SESSION['error'] = "Incorrect password";
          return;
        }
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
  <h1> Please Log In </h1>
  <?php

  if(isset($_SESSION['error'])) {
    echo '<p style = "color:red"> '.htmlentities($_SESSION['error'])."</p>\n";
    unset($_SESSION['error']);
  }
  ?>
  <form method="post">
    <label for "nam">Email </label>
    <input type="text" name="email" id="na" ><br>
    <label for "pas">Password </label>
    <input type="text" name="pass" id="pas"><br>
    <input type="submit" value="Log In" >
    <input type="submit" value="Cancel" name="cancel">
  </form>
  <p>For a password hint, view source and find a password hint in the HTML comments.</p>
  <!-- Hint: The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. --></p>
</div>
</body>
</html>

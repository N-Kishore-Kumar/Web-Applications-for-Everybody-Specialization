<?php
if(isset($_POST['cancel'])) {
  // Redirect the browser to index.php
  header("Location: index.php");
  return;
}
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data
if(isset($_POST['who']) && isset($_POST['pass'])) {
  if(strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
    $failure = "Email and password are required";
  } elseif (strpos($_POST['who'] , "@") === false ) {
    $failure = "Email must have an at-sign (@)";
  }
  else {
      $check = hash('md5', $salt.$_POST['pass']);
      if ( $check == $stored_hash ) {
          // Redirect the browser to autos.php
          error_log("Login success ".$_POST['who']);
          header("Location: autos.php?name=".urlencode($_POST['who']));
          return;
      } else {
          error_log("Login fail ".$_POST['who']." $check");
          $failure = "Incorrect password";
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
  if ( $failure !== false ) {
      // Look closely at the use of single and double quotes
      echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
  }
  ?>
  <form method="post">
    <label for "nam">User name </label>
    <input type="text" name="who" id="na" ><br>
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

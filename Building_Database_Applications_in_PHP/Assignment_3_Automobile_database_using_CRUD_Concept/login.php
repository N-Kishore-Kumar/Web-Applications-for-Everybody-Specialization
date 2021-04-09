<?php
session_start();

if(isset($_POST['email']) && isset($_POST['pass'])) {
  unset($_SESSION['email']);
  if(strlen($_POST['email'])<1 || strlen($_POST['pass'])<1 ) {
    $_SESSION['error']="User name and pass are required";
    header("Location: login.php");
    return;
  }
  if($_POST['pass']=="php123") {  //Password is php123
    $_SESSION['email'] = $_POST['email'];
    header("Location: index.php");
    return;
  }
  else {
    $_SESSION['error']="Incorrect Password";
    header("Location: login.php");
    return;
  }
}
?>
<html>
<title> N Kishore Kumar </title>
<?php require_once "bootstrap.php"; ?>
<body>
  <div class="container">
  <h1> Please Log In </h1>
    <?php
    if(isset($_SESSION['error'])) {
      echo '<p style = "color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
    }
    ?>
    <form method="post">
      <label for="nam">User Name</label>
      <input type="text" name="email" id="nam"></p>
      <label for="id_1723">Password</label>
      <input type="password" name="pass" id="id _1723"</p> <br>
      <input type="submit" value="Log In">
      <a href="index.php"> Cancel </a>
    </form>

    <p>For a password hint, view source and find a password hint in the HTML comments.</p>
      <!-- Hint: The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
  </div>
</body>
</html>

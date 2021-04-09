<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
  <title> N Kishore Kumar </title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
  <div class="container">
  <h1> N Kishore Kumar Resume Registry</h1>
  <?php
if( ! isset($_SESSION['user_id'])) {   ?>
  <p><a href="login.php"> Please log in </a></p>
  <table border="1">
      <tr>
        <th> Name </th>
        <th> Headline </th>
      </tr>
      <?php
      $stmt = $pdo->query("SELECT first_name,last_name,headline FROM profile");
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr><td>";  ?>
          <a href = 'view.php'><?=(htmlentities($row['first_name']).' '.htmlentities($row['last_name']))?>;
          <?php
          echo("</td><td>");
          echo(htmlentities($row['headline']));
          echo("</td></tr>\n");
      }
      ?>
    </table>

<?php  }
else {
  if(isset($_SESSION['success'])) {
  echo '<p style ="color:green">'.$_SESSION['success']."</p>\n" ;
  unset($_SESSION['success']);
} ?>
  <p><a href="logout.php"> Logout </a></p>
  <table border="1">
      <tr>
        <th> Name </th>
        <th> Headline </th>
        <th> Action </th>
      </tr>
      <?php
      $stmt = $pdo->query("SELECT first_name,last_name,headline,profile_id FROM profile");
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr><td>";
          echo("<a href='view.php?profile_id=" . $row['profile_id'] . "'>" . $row['first_name'] . $row['last_name']  . "</a>");
          echo("</td><td>");
          echo(htmlentities($row['headline']));
          echo("</td><td>\n");
          echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
          echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
          echo("</td></tr>\n");
        } ?>
      </table>
      <p> <a href="add.php"> Add New Entry </a></p>

  <?php } ?>


      <p><b>Note:</b>Your implementation should retain data across multiple logout/login sessions.
        This sample implementation clears all its data periodically - which you should not do in your implementation.</p>
      </div>
</body>
</html>

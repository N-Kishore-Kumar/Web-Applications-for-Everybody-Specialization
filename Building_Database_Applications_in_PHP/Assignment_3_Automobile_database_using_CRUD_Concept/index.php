<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
  <title> N Kishore Kumar </title>
</head>
<?php require_once "bootstrap.php"; ?>
<body>
  <div class="container">
  <h1> Welcome to the Automobiles Database</h1>
<?php
if(! isset($_SESSION['email'])) { ?>
  <p> <a href="login.php">Please log in </a></p>
  <p>Attempt to <a href="add.php"> add data  </a> without logging in
<?php }
else {
  $stmt = $pdo->query("SELECT * FROM autos");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    $autos[]=$row;
  }
  if(empty($autos)) {
  ?>  <p> No rows found </p>
  <?php
  }
  else {
    if(isset($_SESSION['success'])) {
    echo '<p style ="color:green">'.$_SESSION['success']."</p>\n" ;
    unset($_SESSION['success']);
    }
  ?>
    <table border="1">
        <tr>
          <th> Make </th>
          <th> Model </th>
          <th> Year </th>
          <th> Mileage </th>
          <th> Action </th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM autos");
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
        }
        ?>
      </table>
 <?php } ?>
      <p><a href="add.php">Add New Entry</a></p>
      <p><a href="logout.php">Logout</a></p>
      <p><b>Note:</b>Your implementation should retain data across multiple logout/login sessions.
        This sample implementation clears all its data on logout - which you should not do in your implementation.</p>
      </div>
</body>
</html>
<?php
}  ?>

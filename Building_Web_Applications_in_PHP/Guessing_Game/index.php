<title>N Kishore Kumar </title>
<h1> Welcome to my guessing game </h1>
<?php
$correctnumber=18;
if (!isset($_GET['guess']))
{
  echo ("Missing guess parameter");
}
elseif (strlen($_GET['guess'])<1)
{
  echo "Your guess is too short";
}
elseif(!is_numeric($_GET['guess']))
{
  echo "Your guess is not a number";
}
elseif ($_GET['guess']<$correctnumber)
{
  echo "Your guess is too low";
}
elseif ($_GET['guess']>$correctnumber)
{
  echo "Your guess is too high";
}
else
{
  echo "Congratulations - You are right";
}

?>

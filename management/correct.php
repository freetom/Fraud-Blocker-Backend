<?php

include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';
include './functions.php';

if(!isset($_POST["i"]))
  die();

if($_SESSION['authorization']==0) //super user
  correct($conn, $_POST["i"]);
else //non-super user
  sayCorrect($conn, $_SESSION['username'], $_POST["i"]);

echo 'ok';
?>

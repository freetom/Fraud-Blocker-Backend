<?php

include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';
include './functions.php';

if(!isset($_POST["i"]))
  die();

if($_SESSION['authorization']==0) //super user
  fraudulent($conn, $_POST["i"],$reportTable,$blackListTable);
else //non-super user
  sayFraudulent($conn, $_SESSION['username'], $_POST["i"], $evaluationTable);

echo 'ok';
?>

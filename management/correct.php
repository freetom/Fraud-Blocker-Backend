<?php

include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';
include './functions.php';

if(!isset($_GET["i"]))
  die();

correct($conn, $_GET["i"],$reportTable,$whiteListTable);
echo 'ok';
?>

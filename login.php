<?php

if(!isset($_POST['username']) || !isset($_POST['password']) )
  die('Empty username or password');

include './api/include/sqlConnect.php';
include './api/include/functions.php';

$res=login($conn,$_POST['username'],$_POST['username'].$_POST['password']);
$res->bind_result($username,$authorization);
$res->fetch();

if(isset($username) && isset($authorization)){
  session_start();
  $_SESSION['username']=$username;
  $_SESSION['authorization']=$authorization;
  header('Location: ./management/manage.php');
}
else
  echo 'login failed';

?>

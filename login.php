<?php

if(!isset($_POST['username']) || !isset($_POST['password']) )
  die('Empty username or password');

include './management/functions.php';

$res=login($conn,$_POST['username'],$_POST['username'].$_POST['password']);
$res->bind_result($username,$authorization,$activated);
$res->fetch();

if(isset($username) && isset($authorization)){
  if(!isset($activated) || $activated==false)
    die('Account unactivated');
  session_start();
  $_SESSION['username']=$username;
  $_SESSION['authorization']=$authorization;
  header('Location: ./management/manage.php');
}
else
  echo 'login failed';

?>

<?php
function fatal($msg){
  header("refresh:3;url=volunteer.php");
  die($msg);
}
if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password1']) )
  fatal('Empty username or password');
if($_POST['password']!=$_POST['password1'])
  fatal('Passwords don\'t match');
if(strlen($_POST['username'])<6)
  fatal('Username must be at least 6 characters long');

include './api/include/sqlConnect.php';
include './api/include/functions.php';

if(register($conn,$_POST['username'],$_POST['username'].$_POST['password'],$userTable))
  fatal('Registration Succeeded, you can now log-in!');
else
  fatal('Username is unusable, please choose another');
?>

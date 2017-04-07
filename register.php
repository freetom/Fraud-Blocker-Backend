<?php
function fatal($msg){
  header("refresh:4;url=volunteer.php");
  die($msg);
}
if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password1']) )
  fatal('Empty username, email or password');
if($_POST['password']!=$_POST['password1'])
  fatal('Passwords don\'t match');
if(strlen($_POST['username'])<5)
  fatal('Username must be at least 5 characters long');
if(preg_match('/[^a-z_\-0-9]/i', $_POST['username']))
  fatal('Username can only contains letters, numbers or \'-\' and \'_\'');
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
  fatal('Invalid email');

include './management/functions.php';

if(register($conn,$_POST['username'],$_POST['username'].$_POST['password'],$_POST['email']))
  fatal('Registration Succeeded, check you inbox (spam box also) for the activation link!');
else
  fatal('Username is unusable, please choose another');
?>

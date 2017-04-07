<?php
if(!isset($_GET['code']))
  die('Missing activation code');
if(preg_match('/[^a-z0-9]/', $_GET['code']) || strlen($_GET['code'])!=64)
  die('Not a valid activation code');

include './api/include/sqlConnect.php';
include './management/functions.php';

cleanup($conn); //call to flush expired activation codes and related users
$res=query($conn,'SELECT username FROM activation WHERE code=?',$_GET['code']);
$res->bind_result($username);
$res->fetch();

if(!isset($username))
  die('Activation code not found, it might be invalid or expired');

query($conn,'DELETE FROM activation WHERE username=?',$username);
query($conn,'UPDATE '.$userTable.' SET activated=true WHERE username=?',$username);

header("refresh:4;url=volunteer.php");
echo 'Activation completed, you can now log-in';
?>

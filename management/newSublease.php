<?php
include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';

if(!isset($_POST['sublease']))
  die('no sublease');

$ns=getFirstNonSuffixDomain($conn,$_POST['sublease']);
if($ns=="")
  die('error in suffix filter');

if(gethostbyname($ns)==$ns)
  die('error, failed lookup');

//when super user ask for activating sublease
if(isset($_POST['activate']) && $_POST['activate']=='1' && $_SESSION['authorization']==0){
  $q='UPDATE '.$subleasesTable.' SET valid=1,timestamp=now() WHERE ns=?';
  $res=query($conn,$q,$ns);
  echo 'ok';
}
else{ //normal user (always) or super user through the insert interface
  $validity=0;
  if($_SESSION['authorization']==0) $validity=1;
  $q='INSERT INTO '.$subleasesTable.'(ns,timestamp,valid) values(?,now(),'.$validity.')';
  $res=query($conn,$q,$ns);
  header('Location: /management/manage.php');
}

?>

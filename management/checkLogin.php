<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['authorization']))
  die('not logged in');
?>

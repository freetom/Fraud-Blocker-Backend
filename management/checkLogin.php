<?php
session_start();
if(!isset($_SESSION['username']))
  die('not logged in');
?>

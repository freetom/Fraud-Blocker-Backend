<?php

if(!isset($_GET['lastUpdate']))
	die('error, no date');

include './include/functions.php';

$lastUpdate=$_GET['lastUpdate'];
if(!isValidDateTime($lastUpdate))
	die('error invalid datetime');

?>
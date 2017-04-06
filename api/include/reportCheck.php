<?php

include './include/functions.php';

if(!isset($_GET['ns']))
	die('error, no ns');
if(!is_valid_domain_name($_GET['ns']))
	die('invalid dns');

$_GET['ns']=strtolower($_GET['ns']);
?>

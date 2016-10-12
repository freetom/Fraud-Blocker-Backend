<?php

include './include/functions.php';

if(!isset($_GET['ns']))
	die('error');
if(!is_valid_domain_name($_GET['ns']))
	die('invalid dns');

?>

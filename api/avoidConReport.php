<?php
//avoid a contro report to a ns

include './include/reportCheck.php';
include './fetch/reports.php';
include './include/suffixFilter.php';
include './include/whiteBlackCheck.php';

$contro_reports-=1;
if($contro_reports>0){
	$q='UPDATE '.$reportTable.' SET contro_reports='.$contro_reports.',timestamp=now() WHERE ns=?';
	query($conn,$q,$ns);
}


echo 'ok '.$ns;

?>

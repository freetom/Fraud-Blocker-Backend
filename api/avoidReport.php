<?php
//avoid a report to a certain ns

include './include/reportCheck.php';
include './fetch/reports.php';
include './include/suffixFilter.php';
include './include/whiteBlackCheck.php';

$reports-=1;
if($reports>=0){
	$q='UPDATE '.$reportTable.' SET reports='.$reports.',timestamp=now() WHERE ns=?';
  query($conn,$q,$ns);
  echo 'ok '.$ns;
}
//else if($reports==0){
  
//	$q='DELETE FROM '.$reportTable.' WHERE ns=?';
//}
//else
//	die('');



?>

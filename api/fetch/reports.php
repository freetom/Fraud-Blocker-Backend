<?php

include './include/sqlConnect.php';

$ns=$_GET['ns'];

$q='SELECT reports,contro_reports FROM '.$reportTable.' WHERE ns=?';
$res=query($conn,$q,$ns);
$res->bind_result($reports,$contro_reports);
$res->fetch();

?>

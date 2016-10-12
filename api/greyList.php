<?php

include './include/datetimeCheck.php';

include './include/sqlConnect.php';

$q='SELECT reports,ns,contro_reports FROM '.$reportTable.' WHERE timestamp>?';
$res=query($conn,$q,$lastUpdate);
$res->bind_result($reports,$ns,$contro_reports);
echo 'list ';
while($res->fetch()){
	echo $ns.' '.$reports.' '.$contro_reports.' ';
}

?>

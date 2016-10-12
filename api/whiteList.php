<?php

include './include/datetimeCheck.php';

include './include/sqlConnect.php';

$q='SELECT ns FROM '.$whiteListTable.' WHERE revoked=false AND timestamp>?';
$res=query($conn,$q,$lastUpdate);
$res->bind_result($ns);
echo 'list ';
while($res->fetch()){
	echo $ns.' ';
}

?>

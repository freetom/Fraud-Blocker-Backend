<?php

include './include/datetimeCheck.php';

include './include/sqlConnect.php';

$q='SELECT ns FROM '.$subleasesTable.' WHERE timestamp>? AND valid=1';
$res=query($conn,$q,$lastUpdate);
$res->bind_result($ns);
echo 'list ';
while($res->fetch()){
  echo $ns.' ';
}

?>

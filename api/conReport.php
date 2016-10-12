<?php
//contro report a ns

include './include/reportCheck.php';
include './fetch/reports.php';
include './include/suffixFilter.php';
include './include/whiteBlackCheck.php';

$q='UPDATE '.$reportTable.' SET contro_reports='.($contro_reports+1).',timestamp=now() WHERE ns=?';

query($conn,$q,$ns);

echo 'ok '.$ns;
?>

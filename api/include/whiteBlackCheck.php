<?php
//check if $ns is contained in the white or in the black list

if(!isset($ns))
  die();

$q='SELECT (SELECT COUNT(*) FROM '.$blackListTable.' WHERE ns=?) + (SELECT COUNT(*) FROM '.$whiteListTable.' WHERE ns=?) as n';
$res=query2($conn,$q,$ns,$ns);
$res->bind_result($n);
$res->fetch();

if($n>0)
  die('Site already classified');

?>

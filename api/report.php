<?php
//report a ns

include './include/reportCheck.php';

if(filter_var($_GET['ns'], FILTER_VALIDATE_IP)){
    if( ($realName=gethostbyaddr($_GET['ns'])) == $_GET['ns'] )
      die('error, failed reverse lookup');
    else
      $_GET['ns']=$realName;
}
else if(gethostbyname($_GET['ns'])==$_GET['ns'])
  die('error, failed lookup');

include './fetch/reports.php';
include './include/suffixFilter.php';
include './include/whiteBlackCheck.php';

//echo $reports.'<br>';
if($reports==0){
  if(!existReport($conn,$ns))
	 $q='INSERT INTO '.$reportTable.'(reports,ns,timestamp,contro_reports) VALUES(1,?,now(),0)';
  else
    $q='UPDATE '.$reportTable.' SET reports='.($reports+1).',timestamp=now() WHERE ns=?';
}
else{
	$q='UPDATE '.$reportTable.' SET reports='.($reports+1).',timestamp=now() WHERE ns=?';
}
query($conn,$q,$ns);

echo 'ok '.$ns;
?>

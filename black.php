<?php

include './api/include/sqlConnect.php';

function sqlExec($conn, $q){
  if(!($stmt=$conn->prepare($q))){
    die('Failed in prepare statement');
  }
  $stmt->execute();
  $stmt->store_result();
  if($stmt->error){
    die($stmt->error);
  }
  return $stmt;
}

$res=sqlExec($conn, 'SELECT ns FROM '.$blackListTable);
$res->bind_result($x);

echo '
<html>
  <body>';
while($res->fetch())
  echo $x.'<br/>';
echo '
  <body>
</html>
';

?>

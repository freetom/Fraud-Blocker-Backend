<?php

include './api/include/sqlConnect.php';
include './api/include/functions.php';

$res=query($conn, 'SELECT ns FROM '.$blackListTable);
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

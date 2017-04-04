<?php
include './api/include/sqlConnect.php';
include './api/include/functions.php';
?>
<br/>
<a href="black.php" target="_blank"><div class="counter"><b class="stat"><?php
          echo getRecordsCount($conn, $blackListTable);
          ?></b> sites blocked</div></a>
<div class="counter" style="background: #D8DBE2;"><b class="stat" id="reported"><?php
          echo getRecordsCount($conn, $reportTable);
          ?></b> sites Reported</div>
<br/><br/>

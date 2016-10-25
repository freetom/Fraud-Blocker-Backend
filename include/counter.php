<?php
include './api/include/sqlConnect.php';
include './api/include/functions.php';
?>
<br/>
<!--<div style="text-align:center"><b>Stats:</b></div>-->
<div class="counter"><b class="stat"><?php 
          echo getFraudSitesCount($conn, $blackListTable);
          ?></b> sites blocked</div>
<!--<div class="counter" style="background: #7ff79e;"><b class="stat" id="unblocked"><?php 
          echo getGoodSitesCount($conn, $whiteListTable);
          ?></b> non-Fraudulent</div>-->
<div class="counter" style="background: #D8DBE2;"><b class="stat" id="reported"><?php 
          echo getReportedSitesCount($conn, $reportTable);
          ?></b> sites Reported</div>
<br/><br/>
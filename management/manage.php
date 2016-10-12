<?php


include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';
include './functions.php';

$res=getReported($conn);
$res->bind_result($reports,$ns,$timestamp,$contro_reports);

?>


<html>
  <head>
    <script type="text/javascript">
    
    function remove(id) {
      return (elem=document.getElementById(id)).parentNode.removeChild(elem);
    }

    function correct(i,j){
      var request = new XMLHttpRequest();
      request.open("GET", "https://"+window.location.hostname+'/management/correct.php?i='+i, true);
      request.onload = function () {
        var response = request.responseText;
        //if(response.indexOf("ok")==-1){
          //alert("Action failed");
        //}
        
        remove("elem"+j);
        
      }
      
      request.send();
    }
    function fraudulent(i,j){
      var request = new XMLHttpRequest();
      request.open("GET", "https://"+window.location.hostname+'/management/fraudulent.php?i='+i, true);
      request.onload = function () {
        var response = request.responseText;
        //if(response.indexOf("ok")==-1){
          //alert(request.responseText);
        //}
        remove("elem"+j);
      }
      
      request.send();
    }
    </script>
  </head>
  <body>
    <table id="reports" style="text-align:center;width:100%;border-collapse: collapse;">
      <tr style="width:100%;">
        <td style="width:16.6%;">name</td><td style="width:16.6%;">Fraudulent reports</td><td style="width:16.6%;">Good reports</td><td style="width:16.6%;">Timestamp</td><td style="width:16.6%;">Move to white</td><td style="width:16.6%;">Move to black</td>
      </tr>
      <tr style="border-bottom: 1px solid #000;width:100%;"></tr>
<?
$i=0;
while($res->fetch()){
  $ns=htmlspecialchars($ns);
  echo '<tr id="elem'.$i.'">';
  echo '<td><a href="http://'.$ns.'">'.$ns.' </a></td><td>'.$reports.'</td><td>'.$contro_reports.'</td><td>'.$timestamp.'</td><td><button onclick="correct(\''.$ns.'\','.$i.');"> correct </button></td><td><button onclick="fraudulent(\''.$ns.'\','.$i.');">fraudulent</button></td>';
  $i++;
  echo '</tr>';
}
?>
      <tr style="border-bottom: 1px solid #000;width:100%;"></tr>
    </table>
  </body>
</html>
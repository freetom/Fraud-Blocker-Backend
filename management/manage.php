<?php


include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';
include './functions.php';

$res=getReported($conn,$_SESSION['username']);
$res->bind_result($reports,$nss,$timestamp,$contro_reports,$say_correct,$say_fraudulent);

?>


<html>
  <head>
    <script type="text/javascript">

    function remove(id) {
      return (elem=document.getElementById(id)).parentNode.removeChild(elem);
    }

    function correct(i,j){
      var request = new XMLHttpRequest();
      var param = 'i='+i;
      request.open("POST", "https://"+window.location.hostname+'/management/correct.php', true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.setRequestHeader("Content-length", param.length);
      request.setRequestHeader("Connection", "close");
      request.onload = function () {
        var response = request.responseText;
        //if(response.indexOf("ok")==-1){
          //alert("Action failed");
        //}
        remove("elem"+j);

      }
      request.send(param);
    }
    function fraudulent(i,j){
      var request = new XMLHttpRequest();
      var param = 'i='+i;
      request.open("POST", "https://"+window.location.hostname+'/management/fraudulent.php', true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.setRequestHeader("Content-length", param.length);
      request.setRequestHeader("Connection", "close");
      request.onload = function () {
        var response = request.responseText;
        //if(response.indexOf("ok")==-1){
          //alert(request.responseText);
        //}
        remove("elem"+j);
      }
      request.send(param);
    }
    function activateSublease(i,j){
      var request = new XMLHttpRequest();
      var param = 'activate=1&sublease='+i;
      request.open("POST", "https://"+window.location.hostname+'/management/newSublease.php', true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.setRequestHeader("Content-length", param.length);
      request.setRequestHeader("Connection", "close");
      request.onload = function () {
        var response = request.responseText;
        //if(response.indexOf("ok")==-1){
          //alert(request.responseText);
        //}
        document.getElementById("subl"+j).remove();
      }
      request.send(param);
    }
    </script>
  </head>
  <body>
    Welcome, <? echo $_SESSION['username'].' ('; if($_SESSION['authorization']!=0) echo 'non '; ?>super user)<br/><a href="/management/changePassword.php">Change your password</a><br/><br/>
    Insert domains that let subleases like 'altervista.org': <form method="POST" action="newSublease.php">
      <input type="text" name="sublease" value="">
      <input type="submit" value="Submit">
    </form>
    <br/><br/>
    <?php
      if($_SESSION['authorization']==0){
        $subl=getUnvalidSubleases($conn);
        $subl->bind_result($sub,$subt);
        echo 'SUBLEASES:<table border=1 style="text-align:center;width:100%;border-collapse: collapse;">';
        $j=0;
        while($subl->fetch()){
            echo '<tr id="subl'.$j.'" style="width:100%;"><td style="width:33%;">'.$sub.'</td><td style="width:33%">'.$subt.'</td><td style="width:33%;"><button onclick="activateSublease(\''.$sub.'\','.$j.')"> OK </button></td> </tr>';
            $j++;
        }
        echo '</table>';
        echo '<hr>';
      }
    ?>
    REPORTS:
    <table id="reports" border="1" style="text-align:center;width:100%;border-collapse: collapse;">
      <tr style="width:100%;">
        <td style="width:12.5%;">name</td><td style="width:12.5%;">Fraudulent reports</td><td style="width:12.5%;">Good reports</td><td style="width:12.5%;">Timestamp</td><td style="width:12.5%;">Say correct</td><td style="width:12.5%;">Say fraudulent</td><td style="width:12.5%;">Move to white</td><td style="width:12.5%;">Move to black</td>
      </tr>
      <tr style="border-bottom: 1px solid #000;width:100%;"></tr>
<?
$i=0;
while($res->fetch()){
  $ns=htmlspecialchars($nss);
  echo '<tr id="elem'.$i.'" onmouseover="this.style.background=\'gray\';" onmouseout="this.style.background=\'white\';">';
  echo '<td><a href="http://'.$ns.'">'.$ns.' </a></td><td>'.$reports.'</td><td>'.$contro_reports.'</td><td>'.$timestamp.'</td><td>'.$say_correct.'</td><td>'.$say_fraudulent.'</td><td><button style="background-color:#00FF22;" onclick="correct(\''.$ns.'\','.$i.');"> correct </button></td><td><button style="background-color:#FF2200;" onclick="fraudulent(\''.$ns.'\','.$i.');">fraudulent</button></td>';
  $i++;
  echo '</tr>';
}
?>
      <tr style="border-bottom: 1px solid #000;width:100%;"></tr>
    </table>
  </body>
</html>

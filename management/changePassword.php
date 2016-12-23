<?php

include './checkLogin.php';
include '../api/include/sqlConnect.php';
include '../api/include/functions.php';
include './functions.php';

if(isset($_POST['password']) && isset($_POST['password1'])){
  if($_POST['password']!=$_POST['password1'])
    die('The two passwords do not match. Try again');
  changePassword($conn,$_SESSION['username'],$_SESSION['username'].$_POST['password']);
  echo 'Password changed successfully!';
  echo '<a href="/management/manage.php>Go back</a>';
}
else{
  ?>
  <html>
    <body>
      <form method="POST" action="/management/changePassword.php">
      <table>
        <tr><td>password:</td><td> <input name="password" type="password" value=""/></td></tr>
        <tr><td>confirm password:</td> <td><input name="password1" type="password" value=""/></td></tr>
        <tr><input type="submit" value="Change password"></tr>
      </table>
      </form>
    </body>
  </html>
  <?php
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <meta charset="UTF-8">
    <title>Fraud Blocker add-on</title>
  </head>
  <body>
    <div id="navigation">
      <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="https://github.com/freetom/Fraud-Blocker-multi-browser-extension" target="_blank">Source code</a></li>
          <li><a href=<? include './include/getExtensionLink.php' ?> target="_blank">Install</a></li>
          <li><a href="quickstart.php">Quickstart</a></li>
          <li id="activelink"><a href="volunteer.php">Volunteer</a></li>
          <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
    <div class="main">
  	  <div style="height:25px; width=100%;"></div>
      <img class="logo" src="images/fraud-200.png" width="100px" height="100px"></img>
      <? include './include/header.php' ?>
      <br/>
      <hr class="horizontal_line"/>
      <br/>
      <form method="POST" action="login.php">
        Username <input type="text" name="username" /><br /><br />
        Password <input type="password" name="password" />
        <br /><br />
        <button>Login</button>
  	  </form>
      <br /><hr class="horizontal_line"><br />
      <div style="margin-left:5%;margin-right:5%;">If you want to become a Volunteer for Fraud Blocker and help us reviewing users' reports, please register here to get an account for the review system:</div>
      <table class="main"><form method="POST" action="register.php">
        <tr><td>Email</td> <td><input type="text" name="email" /></td></tr>
        <tr><td>Username</td> <td><input type="text" name="username" /></td></tr>
        <tr><td>Password</td> <td><input type="password" name="password" /></td></tr>
        <tr><td>Confirm password</td> <td><input type="password" name="password1" /></td></tr>
        <tr><td><button>Register</button></td></tr>
      </form></table>
      The information provided in the above form will only be used to verify email ownership and to authenticate you.
      <br /><hr class="horizontal_line">
      <?php include './include/counter.php' ?>
    </div>
    <div class="footer">
      Fraud Blocker is free software, it respects your freedom! (<a href="https://www.gnu.org/licenses/quick-guide-gplv3.html" target="blank_">GPLv3</a>)
    </div>
  </body>
</html>

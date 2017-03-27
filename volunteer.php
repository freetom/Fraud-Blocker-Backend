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
      <br /><br />
      If you want to become a Volunteer for Fraud Blocker and help us reviewing users' reports, please contact <i>tomasbortoli@gmail.com</i>
      <br /><hr class="horizontal_line">
      <?php include './include/counter.php' ?>
    </div>
    <div class="footer">
      Fraud Blocker is free software, it respects your freedom! (<a href="https://www.gnu.org/licenses/quick-guide-gplv3.html" target="blank_">GPLv3</a>)
    </div>
  </body>
</html>

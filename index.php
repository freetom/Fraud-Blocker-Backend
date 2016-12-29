<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <title>Fraud Blocker add-on</title>
  </head>
  <body>
    <div id="navigation">
      <ul>
          <li id="activelink"><a href="index.php">Home</a></li>
          <li><a href="https://github.com/freetomas/Fraud-Blocker-multi-browser-extension" target="_blank">Source code</a></li>
          <li><a href=<? include './include/getExtensionLink.php' ?> target="_blank">Install</a></li>
          <li><a href="quickstart.php">Quickstart</a></li>
          <li><a href="volunteer.php">Volunteer</a></li>
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
      <ul class="features">
        <li class="feature">
          It <b>Protects</b> you from Fraudlent sites
        </li>
        <li class="feature">
          It <b>Warns</b> you when accessing a site reported as Fraudlent by other users (but still not confirmed to be a Fraud)
        </li>
        <li class="feature">
          It Gives you the possibility to give <b>Fraud-Feedback</b> using the button on toolbar (<img src="images/fraud-200.png" class="icon_fraud" />)
        </li>
      </ul>
      <hr class="horizontal_line"/>
      <div style="margin-left:5%;margin-right:5%;padding-top:5%;padding-bottom:5%;font-size:1.0em;">
        Basically is a real-time system that allows people to report or contro-report fraudulent/dishonest/scam/fake/dangerous sites that will be then verified by us and eventually blocked.
        <br/>
        Is there a better way to fight scam than a community based system?
      </div>
      <hr class="horizontal_line"/>

      <? include './include/counter.php' ?>
    </div>
    <div class="footer">
      Fraud Blocker is free software, it respects your freedom! (<a href="https://www.gnu.org/licenses/quick-guide-gplv3.html" target="blank_">GPLv3</a>)
    </div>
  </body>
</html>

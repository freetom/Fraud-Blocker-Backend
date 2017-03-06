<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <meta charset="UTF-8">
    <title>Quickstart </title>
  </head>
  <body>
    <div id="navigation">
      <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="https://github.com/freetom/Fraud-Blocker-multi-browser-extension" target="_blank">Source code</a></li>
          <li><a href=<? include './include/getExtensionLink.php' ?> target="_blank">Install</a></li>
          <li id="activelink"><a href="quickstart.php">Quickstart</a></li>
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
      <div class="quickstart">
        <p><h1>Quickstart</h1></p>
        <ol>
          <li class="step">To begin, install Fraud Blocker from <a href=<? print_link(); ?> target="_blank">here</a></li>
          <li class="step">Then you shoud see its icon on the toolbar (<img src="images/fraud-200.png" class="icon_fraud"/>). If you don't see the icon probably you've not installed the plug-in.</li>
          <li class="step">If the installation was successful you're now <b>protected</b> by Fraud Blocker. You can browse the internet normally as before. If you hit a Fraudlent site (that is in our database) the page will be blocked. You can click on <img src="images/fraud-200.png" class="icon_fraud"/>, then ignore the <b>danger</b> and browse the site normally.</li>
          <li class="step">You will be <b>warned</b> by a number on the button on toolbar (example: <img src="images/fraud-1.png" class="small_icon_fraud"/>) of people that reported a site  when accessing a site reported as fraudlent by other users but still not confirmed from us.</li>
          <li class="step">You can <b>give fraud feedback</b> on a site by pressing the icon (<img src="images/fraud-200.png" class="icon_fraud"/>) on toolbar while the site is open to report it as fraudlent or contro-report it as good.</li>
        <ol>
      </div>
      <br/>
      <hr class="horizontal_line"/>
      <?php include './include/counter.php' ?>
    </div>
    <div class="footer">
      Fraud Blocker is free software, it respects your freedom! (<a href="https://www.gnu.org/licenses/quick-guide-gplv3.html" target="blank_">GPLv3</a>)
    </div>
  </body>
</html>

<?php
function is_chrome()
{
  if(isset($_SERVER['HTTP_USER_AGENT']))
    return strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "chrome");
  else
    return false;
}
function is_firefox()
{
  if(isset($_SERVER['HTTP_USER_AGENT']))
    return strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "firefox");
  else
    return false;
}
function is_edge()
{
  if(isset($_SERVER['HTTP_USER_AGENT']))
    return strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "edge");
  else
    return false;
}

function print_link(){
  if(is_edge())
    echo '"unsupported.php"';
  else if(is_firefox())
    echo '"https://addons.mozilla.org/en-US/firefox/addon/fraud-blocker/"';
  else if(is_chrome())
    echo '"https://chrome.google.com/webstore/detail/fraud-blocker/mbkgkcnibjdpieobolniabeakmlpfhhk"';
  else
    echo 'unsupported.php';
}

print_link();

?>

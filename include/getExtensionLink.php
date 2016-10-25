<?php
function is_chrome()
{
  return(eregi("chrome", $_SERVER['HTTP_USER_AGENT']));
}
function is_firefox()
{
  return(eregi("firefox", $_SERVER['HTTP_USER_AGENT']));
}

if(is_firefox())
  echo '"https://addons.mozilla.org/en-US/firefox/addon/fraud-blocker/"';
else if(is_chrome())
  echo '"https://chrome.google.com/webstore/detail/fraud-blocker/mbkgkcnibjdpieobolniabeakmlpfhhk"';

?>

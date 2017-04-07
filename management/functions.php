<?php

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR .'../api/include/sqlConnect.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR .'../api/include/functions.php';

//return reported sites except those already evaluated by the current user
//the logic of the query below implies that no username in the db can be a contained in any other; if a correct behavior is wanted (other functions will preserve this property)
function getReported($conn, $username){
  global $evaluationTable,$reportTable;
  return query($conn,'select reports,ns as nss,timestamp,contro_reports,(select GROUP_CONCAT(username SEPARATOR \',\') from '.$evaluationTable.' where fraudulent=false and ns=nss group by ns) as say_correct,(select GROUP_CONCAT(username SEPARATOR \',\') from '.$evaluationTable.' where fraudulent=true and ns=nss group by ns) as say_fraudulent from '.$reportTable.' group by ns having (not say_correct like ? or say_correct IS NULL) and (not say_fraudulent like ? or say_fraudulent IS NULL) ORDER BY timestamp DESC LIMIT 100;','%'.$username.'%','%'.$username.'%');
}

function getUnvalidSubleases($conn){
  global $subleasesTable;
  return query($conn,'SELECT ns,timestamp FROM '.$subleasesTable.' WHERE valid=0;');
}

//can only be performed by super-users
function activateSublease($con,$sub){
  global $subleasesTable;
  query($con,'UPDATE '.$subleasesTable.' SET valid=1 WHERE ns=?;',$sub);
}

//called when a super-user evaluate a site as correct
function correct($con, $ns){
  removeGrey($con, $ns);
  addWhite($con, $ns);
}

//called when a super-user evaluate a site as fraudulent
function fraudulent($con, $ns){
  removeGrey($con, $ns);
  addBlack($con, $ns);
}

function removeGrey($con, $ns){
  global $reportTable;
  query($con, 'DELETE FROM '.$reportTable.' WHERE ns=?',$ns);
}
function addWhite($con, $ns){
  global $whiteListTable;
  query($con, 'INSERT INTO '.$whiteListTable.'(ns,timestamp) VALUES(?,now())',$ns);
}
function addBlack($con, $ns){
  global $blackListTable;
  query($con, 'INSERT INTO '.$blackListTable.'(ns,timestamp) VALUES(?,now())',$ns);
}

//called when a non-super user evaluate a site as fraudulent
function sayFraudulent($con, $username, $ns){
  global $evaluationTable;
  query($con, 'INSERT INTO '.$evaluationTable.'(username,ns,fraudulent) values(?,?,true)',$username,$ns);
}
//called when a non-super user evaluate a site as correct
function sayCorrect($con, $username, $ns){
  global $evaluationTable;
  query($con, 'INSERT INTO '.$evaluationTable.'(username,ns,fraudulent) values(?,?,false)',$username,$ns);
}


//note that $username is treated as sanitized input because normally it is defined by the php
function changePassword($con, $username, $password){
  query($con, 'UPDATE users SET password=SHA1(?) WHERE username=?',$password,$username);
}


function login($conn,$username,$password){
  global $userTable;
	return query($conn,'SELECT username,authorization,activated FROM '.$userTable.' WHERE username=? AND password=SHA1(?)',$username,$password);
}

function register($conn,$username,$password,$email){
  global $userTable;
  cleanup($conn);
  //check that the provided username is not contained and doesn't contain any already existing username
  $res=query($conn,'select username as x from '.$userTable.' where username LIKE ? OR ? LIKE CONCAT(\'%\',username,\'%\');','%'.$username.'%',$username);
  $res->bind_result($x);
  $res->fetch();
  if(isset($x))
    return false;
  query($conn,'INSERT INTO '.$userTable.'(username,password,email) values(?,SHA1(?),?)',$username,$password,$email);
  sendActivationLink($conn,$username,$email);
  return true;
}

function getRandomString($random_string_length){
  $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $string = '';
  $max = strlen($characters) - 1;
  for ($i = 0; $i < $random_string_length; $i++) {
      $string .= $characters[mt_rand(0, $max)];
  }
  return $string;
}

//trigger elimination of expired records to avoid to fill the database of activation codes and unactivated users
function cleanup($conn){
  global $activationTable,$userTable;
  $res=query($conn,'SELECT username FROM '.$activationTable.' WHERE timestamp< (NOW() - INTERVAL 20 MINUTE)');
  $res->bind_result($expired_username);
  while($res->fetch()){
    query($conn,'DELETE FROM '.$userTable.' WHERE username=?',$expired_username);
  }
  query($conn,'DELETE FROM '.$activationTable.' WHERE timestamp< (NOW() - INTERVAL 20 MINUTE)');
}

function sendActivationLink($conn,$username,$email){
  global $activationTable;
  $code=getRandomString(64);

  $message='
  <html><body>
  Thanks for registering as a reviewer on Fraud Blocker.<br />
  To activate your account <a href="https://fraudblocker.publicvm.com/activate.php?code='.$code.'">CLICK HERE</a><br /><br />

  If you didn\'t requested the registration, please ignore this email. <br />
  </body></html>';
  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html; charset=iso-8859-1';
  $headers[] = 'From: Fraud Blocker <register@fraudblocker.publicvm.com>';
  mail($email, 'Welcome on Fraud Blocker', $message, implode("\r\n", $headers));

  query($conn,'INSERT INTO '.$activationTable.'(username,email,code,timestamp) VALUES(?,?,?,now())',$username,$email,$code);
}

?>

<?php

include_once '../api/include/sqlConnect.php';
include_once '../api/include/functions.php';

function getReported($conn, $username){
  global $evaluationTable;
  return query($conn,'select reports,ns as nss,timestamp,contro_reports,(select GROUP_CONCAT(username SEPARATOR \',\') from '.$evaluationTable.' where fraudulent=false and ns=nss group by ns) as say_correct,(select GROUP_CONCAT(username SEPARATOR \',\') from evaluation where fraudulent=true and ns=nss group by ns) as say_fraudulent from reported_sites group by ns having (not say_correct like ? or say_correct IS NULL) and (not say_fraudulent like ? or say_fraudulent IS NULL) ORDER BY timestamp DESC LIMIT 100;','%'.$username.'%','%'.$username.'%');
}

function getUnvalidSubleases($conn){
  global $subleasesTable;
  return query($conn,'SELECT ns,timestamp FROM '.$subleasesTable.' WHERE valid=0;');
}

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

?>

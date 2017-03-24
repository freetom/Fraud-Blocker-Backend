<?php

function getReported($conn, $username){
  return sqlExec($conn,'select reports,ns as nss,timestamp,contro_reports,(select GROUP_CONCAT(username SEPARATOR \',\') from evaluation where fraudulent=false and ns=nss group by ns) as say_correct,(select GROUP_CONCAT(username SEPARATOR \',\') from evaluation where fraudulent=true and ns=nss group by ns) as say_fraudulent from reported_sites group by ns having (not say_correct like \'%'.$username.'%\' or say_correct IS NULL) and (not say_fraudulent like \'%'.$username.'%\' or say_fraudulent IS NULL) ORDER BY timestamp DESC LIMIT 100;');
}

function getUnvalidSubleases($conn){
  return sqlExec($conn,'SELECT ns,timestamp FROM subleases WHERE valid=0;');
}

function activateSublease($con,$sub){
  sqlExec($con,'UPDATE subleases SET valid=1 WHERE ns=?;',$sub);
}

//called when a super-user evaluate a site as correct
function correct($con, $ns, $reportTable, $whiteListTable){
  removeGrey($con, $ns, $reportTable);
  addWhite($con, $ns, $whiteListTable);
}

//called when a super-user evaluate a site as fraudulent
function fraudulent($con, $ns, $reportTable, $blackListTable){
  removeGrey($con, $ns, $reportTable);
  addBlack($con, $ns, $blackListTable);
}

function removeGrey($con, $ns, $reportTable){
  sqlExec($con, 'DELETE FROM '.$reportTable.' WHERE ns=?',$ns);
}
function addWhite($con, $ns, $whiteListTable){
  sqlExec($con, 'INSERT INTO '.$whiteListTable.'(ns,timestamp) VALUES(?,now())',$ns);
}
function addBlack($con, $ns, $blackListTable){
  sqlExec($con, 'INSERT INTO '.$blackListTable.'(ns,timestamp) VALUES(?,now())',$ns);
}

//called when a non-super user evaluate a site as fraudulent
function sayFraudulent($con, $username, $ns, $evaluationTable){
  sqlExec($con, 'INSERT INTO '.$evaluationTable.'(username,ns,fraudulent) values(\''.$username.'\',?,true)',$ns);
}
//called when a non-super user evaluate a site as correct
function sayCorrect($con, $username, $ns, $evaluationTable){
  sqlExec($con, 'INSERT INTO '.$evaluationTable.'(username,ns,fraudulent) values(\''.$username.'\',?,false)',$ns);
}


//note that $username is treated as sanitized input because normally it is defined by the php
function changePassword($con, $username, $password){
  sqlExec($con, 'UPDATE users SET password=SHA1(?) WHERE username=\''.$username.'\'',$password);
}

function sqlExec($conn, $q){
  if(!($stmt=$conn->prepare($q))){
    die('Failed in prepare statement');
  }
  if(count(func_get_args())>=3)
    $stmt->execute(array_slice(func_get_args(), 2));
  else
    $stmt->execute();

  $stmt->store_result();
  if($stmt->error){
    die($stmt->error);
  }
  return $stmt;
}

?>

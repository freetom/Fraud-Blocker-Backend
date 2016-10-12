<?php

function getReported($conn){
  $q='SELECT reports,ns,timestamp,contro_reports FROM reported_sites ORDER BY reports DESC LIMIT 100';
  if(!($stmt=$conn->prepare($q))){
    die('Failed in prepare statement');
  }
  $stmt->execute();
  $stmt->store_result();
  if($stmt->error){
    die($statement->error);
  }
  return $stmt;
}

function correct($con, $ns, $reportTable, $whiteListTable){
  removeGrey($con, $ns, $reportTable);
  addWhite($con, $ns, $whiteListTable);
}

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

function sqlExec($conn, $q, $var){
  if(!($stmt=$conn->prepare($q))){
    die('Failed in prepare statement');
  }
  $stmt->bind_param("s",$var);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->error){
    die($stmt->error);
  }
  return $stmt;
}

?>

<?php

function is_valid_domain_name($ns)
{
  return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $ns) //valid chars check
          && preg_match("/^.{1,253}$/", $ns) //overall length check
          && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $ns)   ); //length of each label
}


function isSuffix($conn,$ns){
	$q='SELECT ns FROM public_suffix_list WHERE ns=?';
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->bind_param("s",$ns);
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	$stmt->bind_result($res);
	$stmt->fetch();
	
	if(isset($res))
		return true;
	else
		return false;
}

//given a domain return the first part of it that is a non-suffix-domain
//in other words, the first subns that isn't contained in the PSL (public suffixes list)
function getFirstNonSuffixDomain($conn,$ns){
	$i=strlen($ns)-1;
	$gotPoint=false;
	while($i>0){
		if($ns[$i]=='.'){
			if(!$gotPoint)
				$gotPoint=true;
			else if(!isSuffix($conn,substr($ns,$i+1)))
					return substr($ns,$i+1);
		}
		$i--;
	}
	if(!isSuffix($conn,$ns))
		return $ns;
	else
		return "";
}

//check if a report for a ns exist
function existReport($conn,$ns){
	$q='SELECT ns FROM reported_sites WHERE ns=?';
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->bind_param("s",$ns);
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	$stmt->bind_result($res);
	$stmt->fetch();

	return $res==$ns;
}

function query($conn,$q,$x){
	//echo $q.'<br>';
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->bind_param("s",$x);
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	return $stmt;
}

//same as query but with 2 strings as *safe* param in the query
function query2($conn,$q,$x,$y){
	//echo $q.'<br>';
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->bind_param("ss",$x,$y);
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	return $stmt;
}

function login($conn,$username,$password){
	$q='SELECT username FROM users WHERE username=? AND password=SHA1(?)';
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->bind_param("ss",$username,$password);
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	return $stmt;
}

function isValidDateTime($lastUpdate){
	if(!preg_match('/[^0-9\-: ]/', $lastUpdate))
	  return true;
	else
		return false;
}

function getTimeNormalized(){
	$time = time();
	//$check = $time+date("Z",$time);
	echo strftime("%Y-%m-%d %H:%M:%S", $time);
}


function getFraudSitesCount($conn, $blackListTable){
	$q='SELECT COUNT(*) as x FROM  '.$blackListTable;
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	$stmt->bind_result($x);
	$stmt->fetch();
	return $x;
}

function getGoodSitesCount($conn, $whiteListTable){
	$q='SELECT COUNT(*) as x FROM  '.$whiteListTable;
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	$stmt->bind_result($x);
	$stmt->fetch();
	return $x;
}

function getReportedSitesCount($conn, $reportTable){
	$q='SELECT COUNT(*) as x FROM  '.$reportTable;
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->execute();
	//echo $stmt->fullQuery;
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	$stmt->bind_result($x);
	$stmt->fetch();
	return $x;
}

?>

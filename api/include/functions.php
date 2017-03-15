<?php

function is_valid_domain_name($ns)
{
  return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $ns) //valid chars check
          && preg_match("/^.{1,253}$/", $ns) //overall length check
          && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $ns)   ); //length of each label
}


function isSuffix($conn,$ns){
	$q='SELECT ns as n FROM public_suffix_list WHERE ns=?';
	$res=query($conn,$q,$ns);
	$res->bind_result($n);
	$res->fetch();
	return $n!="";
}

function checkNsSublease($conn,$ns){
	$q='SELECT ns as n FROM subleases WHERE ns=?';
	$res=query($conn,$q,$ns);
	$res->bind_result($n);
	$res->fetch();
	return $n!="";
}
//given a domain return the first part of it that is a non-suffix-domain
//in other words, the first subns that isn't contained in the PSL (public suffixes list)
function getFirstNonSuffixDomain($conn,$ns){
	$i=strlen($ns)-1;
	$gotPoint=false;
	while($i>0){
		if($ns[$i]=='.'){
			if(!$gotPoint){
				$gotPoint=true;
				//check that the first right part of the ns exist in the PSL
				if(!isSuffix($conn,substr($ns,$i+1)))
					return "";
			}
			else if(!isSuffix($conn,substr($ns,$i+1)) ){
				if(checkNsSublease($conn,substr($ns,$i+1)) )
					$i+=0;
				else
					return substr($ns,$i+1);
			}
		}
		$i--;
	}
	if($gotPoint && !isSuffix($conn,$ns))
		return $ns;
	else
		return "";
}

//check if a report for a ns exist
function existReport($conn,$ns){
	$q='SELECT ns as n FROM reported_sites WHERE ns=?';
	$res=query($conn,$q,$ns);
	$res->bind_result($n);
	$res->fetch();
	return $n!="";
}

//query with no additional parameters
function query_($conn,$q){
	if(!($stmt=$conn->prepare($q))){
		die('Failed in prepare statement');
	}
	$stmt->execute();
	$stmt->store_result();
	if($stmt->error){
		die($stmt->error);
	}
	return $stmt;
}

//run query with one additional parameter (string)
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

//same as query but with 2 strings as secure/filtered parameters in the query
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
	$q='SELECT username,authorization FROM users WHERE username=? AND password=SHA1(?)';
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
	echo strftime("%Y-%m-%d %H:%M:%S", $time);
}


function getFraudSitesCount($conn, $blackListTable){
	$q='SELECT COUNT(*) as n FROM '.$blackListTable;
	$res=query_($conn,$q);
	$res->bind_result($n);
	$res->fetch();
	return $n;
}

function getGoodSitesCount($conn, $whiteListTable){
	$q='SELECT COUNT(*) as n FROM '.$whiteListTable;
	$res=query_($conn,$q);
	$res->bind_result($n);
	$res->fetch();
	return $n;
}

function getReportedSitesCount($conn, $reportTable){
	$q='SELECT COUNT(*) as n FROM '.$reportTable;
	$res=query_($conn,$q);
	$res->bind_result($n);
	$res->fetch();
	return $n;
}

?>

<?php

include_once 'sqlConnect.php';

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
  global $subleasesTable;
	$q='SELECT ns as n FROM '.$subleasesTable.' WHERE ns=?';
	$res=query($conn,$q,$ns);
	$res->bind_result($n);
	$res->fetch();
	return $n!="";
}

//given a domain return the first part of it that is a non-suffix-domain
//in other words, the first subns that isn't contained in the PSL (public suffixes list)
//also, if resulting ns match a sublease ns, skip and go deeper
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

//check if a report for a ns exists
function existReport($conn,$ns){
  global $reportTable;
	$q='SELECT ns as n FROM '.$reportTable.' WHERE ns=?';
	$res=query($conn,$q,$ns);
	$res->bind_result($n);
	$res->fetch();
	return $n!="";
}

//check if a report for a url exists
function existURL($conn,$url){
  global $urlTable;
	$q='SELECT ns as n FROM '.$urlTable.' WHERE ns=?';
	$res=query($conn,$q,$url);
	$res->bind_result($n);
	$res->fetch();
	return $n!="";
}

function query($conn, $q){
  if(!($stmt=$conn->prepare($q))){
    die('Failed in prepare statement');
  }
  $len=count(func_get_args());
  if($len>2){
    $params=array_slice(func_get_args(), 2);
    if(($len=count($params))==1)
      $stmt->bind_param("s",$params[0]);
    else if($len==2)
      $stmt->bind_param("ss",$params[0],$params[1]);
    else if($len==3)
      $stmt->bind_param("sss",$params[0],$params[1],$params[2]);
    else if($len==4)
      $stmt->bind_param("ssss",$params[0],$params[1],$params[2],$params[3]);
    else
      die('unsupported');
  }
  $stmt->execute();

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

function getRecordsCount($conn, $table){
	$q='SELECT COUNT(*) as n FROM '.$table;
	$res=query($conn,$q);
	$res->bind_result($n);
	$res->fetch();
	return $n;
}

?>

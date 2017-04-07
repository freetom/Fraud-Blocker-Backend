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
  global $reportTable;
	$q='SELECT ns as n FROM '.$reportTable.' WHERE ns=?';
	$res=query($conn,$q,$ns);
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

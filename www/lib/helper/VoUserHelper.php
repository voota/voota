<?php
function fullName( $user ) {
  	$ret = "";
  	
  	if ($user->getProfile()->getNombre()){
  		$ret .= $user->getProfile()->getNombre();
  		if ($user->getProfile()->getApellidos()){
  			$ret .= " " . $user->getProfile()->getApellidos();
  		}
  	}
  	else if ($user->getCurrentFacebookUid()){
  		$ret .= "<fb:name uid=\"". $user->getCurrentFacebookUid() ."\" useyou=\"false\" ></fb:name>";
  	}
  	
  	return $ret;
}

<?php
function fullName( $user ) {
  	$ret = "vo:";
  	
  	if ($user->getProfile()->getNombre()){
  		$ret .= $user->getProfile()->getNombre();
  		if ($user->getProfile()->getApellidos()){
  			$ret .= " " . $user->getProfile()->getApellidos();
  		}
  	}
  	else if ($user->getProfile()->getFacebookUid()){
  		$ret .= "<fb:name uid=\"". $user->getProfile()->getFacebookUid() ."\" useyou=\"false\" linked=\"false\"></fb:name>";
  	}
  	
  	return $ret;
}

function getAvatar( $user ) {
  	$ret = "";

    if( $user->getProfile()->getImagen() ){
    	$ret .= image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $user->getProfile()->getImagen()), array('alt' => fullName( $user ), 'width' => 36, 'height' => 36));
    }
    else if ($user->getProfile()->getFacebookUid()){
  		$ret .= "<fb:profile-pic uid=\"".$user->getProfile()->getFacebookUid() ."\" size=\"square\" facebook-logo=\"true\" width=\"36\" height=\"36\"></fb:profile-pic>";
  	}
  	else {
  		$ret .= image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', array('alt' => fullName( $user ), 'width' => 36, 'height' => 36));
  	}
    
  	
  	return $ret;
}


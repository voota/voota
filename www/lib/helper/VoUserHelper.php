<?php
function fullName( $user ) {
  	$ret = "vo:";
  	
  	if ($user && $user->getProfile()->getNombre()){
  		$ret .= $user->getProfile()->getNombre();
  		if ($user->getProfile()->getApellidos()){
  			$ret .= " " . $user->getProfile()->getApellidos();
  		}
  	}
  	else if ($user && $user->getProfile()->getFacebookUid()){
  		$ret .= "<fb:name uid=\"". $user->getProfile()->getFacebookUid() ."\" useyou=\"false\" linked=\"false\" ifcantsee=\"Facebook_".$user->getProfile()->getFacebookUid()."\"></fb:name>";
  	}
  	
  	return $ret;
}

function fullNameForAttr( $user ) {
  // TODO: Refactorizar con fullName

	if ($user && $user->getProfile()->getNombre()){
		$ret .= $user->getProfile()->getNombre();
		if ($user->getProfile()->getApellidos()){
			$ret .= " " . $user->getProfile()->getApellidos();
		}
	}
	else if ($user && $user->getProfile()->getFacebookUid()){
		__("Usuario de Facebook").' '.$user->getProfile()->getFacebookUid();
	}
}

function getAvatar( $user ) {
  	$ret = "";

    if( $user && $user->getProfile()->getImagen() ){
    	$ret .= image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $user->getProfile()->getImagen()), array('alt' => fullName( $user ), 'width' => 36, 'height' => 36));
    }
    else if ( $user && $user->getProfile()->getFacebookUid()){
  		$ret .= "<fb:profile-pic uid=\"".$user->getProfile()->getFacebookUid() ."\" size=\"square\" facebook-logo=\"true\" width=\"36\" height=\"36\"></fb:profile-pic>";
  	}
  	else {
  		$ret .= image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', array('alt' => fullName( $user ), 'width' => 36, 'height' => 36));
  	}
    
  	
  	return $ret;
}

function getAvatarFull( $user ) {
  // TODO: Refactorizar con getAvatar

  $ret = "";

  if( $user && $user->getProfile()->getImagen() ){
  	$ret .= image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_'.( $user->getProfile()->getImagen()), array('alt' => fullName( $user )));
  }
  else if ( $user && $user->getProfile()->getFacebookUid()){
		$ret .= "<fb:profile-pic uid=\"".$user->getProfile()->getFacebookUid() ."\" size=\"normal\" facebook-logo=\"true\"></fb:profile-pic>";
	}

	return $ret;
}

function vo_facebook_connect_button() {
	return "<a id=\"fbc_button\" href=\"#\">".  image_tag('/sfFacebookConnectPlugin/images/fb_light_medium_short.gif', 'alt="Facebook Connect"') . "</a>";
}
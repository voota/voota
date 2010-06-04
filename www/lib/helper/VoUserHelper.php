<?php
function fullName( $user, $length = false ) {
  	$ret = "";
  	
  	if ($user && $user->getProfile()->getNombre()){
  		$ret .= $user->getProfile()->getNombre();
  		if ($user->getProfile()->getApellidos()){
  			$ret .= " " . $user->getProfile()->getApellidos();
  		}
  		if ($length){
  			$ret = sfVoUtil::cutToLength( $ret, $length );
  		}
  	}
  	else if ($user && $user->getProfile()->getFacebookUid()){
  		$ret .= jsWrite("<fb:name uid=\"". $user->getProfile()->getFacebookUid() ."\" useyou=\"false\" linked=\"false\" ifcantsee=\"Facebook_".$user->getProfile()->getFacebookUid()."\"></fb:name>");
  	}
  	
  	return $ret;
}

function party( $user ) {
	$ret = "";
  	
	$politico = isPolitico($user);
	
  	if ($politico && $politico->getPartido()){
  		$ret = " (". $politico->getPartido() .")";
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

function getAvatar( $user, $width = 36, $height = 36) {
  	$ret = "";

    if( $user && $user->getProfile()->getImagen() ){
    	$ret .= image_tag(S3Voota::getImagesUrl().'/usuarios/cc_s_'.( $user->getProfile()->getImagen()), array('alt' => fullName( $user ), 'width' => 36, 'height' => 36));
    }
    else if ( $user && $user->getProfile()->getFacebookUid()){
  		$ret .= jsWrite( "<fb:profile-pic uid=\"".$user->getProfile()->getFacebookUid() ."\" size=\"square\" facebook-logo=\"true\" width=\"$width\" height=\"$height\"></fb:profile-pic>" );
  	}
  	else {
  		$ret .= image_tag(S3Voota::getImagesUrl().'/usuarios/v.png', array('alt' => fullName( $user ), 'width' => $width, 'height' => $height));
  	}
    
  	
  	return $ret;
}

function getAvatarFull( $user ) {
  // TODO: Refactorizar con getAvatar

  $ret = "";

  if( $user && $user->getProfile()->getImagen() ){
  	$ret .= image_tag(S3Voota::getImagesUrl().'/usuarios/cc_'.( $user->getProfile()->getImagen()), array('alt' => fullName( $user )));
  }
  else if ( $user && $user->getProfile()->getFacebookUid()){
		$ret .= jsWrite( "<fb:profile-pic uid=\"".$user->getProfile()->getFacebookUid() ."\" size=\"normal\" facebook-logo=\"true\"></fb:profile-pic>" );
	}

	return $ret;
}

function vo_facebook_connect_button() {
	return "<a class=\"fbconnect_login_button\" href=\"#\">".  image_tag('/sfFacebookConnectPlugin/images/fb_light_medium_short.gif', 'alt="Facebook Connect"') . "</a>";
}

function vo_facebook_connect_ajax_button($box, $func_name) {
  // FIXME: ¿Nos hace falta para algo más que para asociar el usuario? Si no, eliminar
	$func = $func_name."('". url_for('@usuario_fb_edit') ."', '$box')";
	return "<a id='fbc_button_c' onclick=\"return $func\" href='#'>".  image_tag('/sfFacebookConnectPlugin/images/fb_light_medium_short.gif', 'alt="Facebook Connect"') . "</a>";
}

function vo_facebook_connect_associate_button($text = '', $box = 'facebook-connect') {
  $func = "facebookConnect_associate('". url_for('@usuario_fb_edit?op=con&box='.$box). "', '$box')";
  return "<a id='fbc_button_c' onclick=\"return $func\" href='#'>".  ($text?$text:image_tag('/sfFacebookConnectPlugin/images/fb_light_medium_short.gif', 'alt="Facebook Connect"')) . "</a>";
}

function isPolitico($user){
	$ret = false;
  	if($user && count($user->getPoliticos()) > 0 ){
  		$politicos = $user->getPoliticos();
  		$politico = $politicos[0];
  		$ret = $politico;
  	}
  	
  	return $ret;
}

 
function changeCulture( $culture ){
	$extensions = array('es' => 'es', 'ca' => 'cat');
	
	$sf_context = sfContext::getInstance();
	$request = $sf_context->getRequest();
	$parameters = $request->getParameterHolder()->getAll();
	$curCulture = $sf_context->getUser()->getCulture('es');
	$routeName = $sf_context->getRouting()->getCurrentRouteName();
	$routeName = preg_replace("/_$curCulture$/", "_$culture", $routeName);
	$params = "";
	foreach($parameters as $name => $value){
		if ($name != 'module' && $name != 'action') {
			if ($name == 'institucion'){
				$c = new Criteria();
				$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
				$c->addJoin(
					array(InstitucionPeer::ID, InstitucionI18nPeer::CULTURE),
					array(InstitucionI18nPeer::ID, "'$curCulture'")
					, Criteria::INNER_JOIN
				);
				$c->add(InstitucionI18nPeer::VANITY, $value);
				$aInstitucion = InstitucionPeer::doSelectOne( $c );
				if ($aInstitucion){
					$value = $aInstitucion->getVanity( $culture );
				}
			}
			$params .= ($params == ""?'?':'&'). "$name=$value";
		}
	}
	$route = sfContext::getInstance()->getController()->genUrl("@$routeName$params");
	
	$host = preg_replace("/\.[a-zA-Z]*$/is", ".".$extensions[$culture], $_SERVER['HTTP_HOST']);
	
	return "http://$host$route";
}

function jsWrite( $str ){
	return "<script type=\"text/javascript\">document.write('$str');</script>";
}
<?php require_once('VoSmartJSHelper.php') ?><?php
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
    // else if ($user && $user->getProfile()->getFacebookUid()){
    //  $ret .= jsWrite('fb:name', array('uid' => $user->getProfile()->getFacebookUid(), 'useyou' => 'false', 'linked' => 'false', 'ifcantsee' => "Facebook_".$user->getProfile()->getFacebookUid()));
    // }
  	
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
    if ($user) { // FIXME: ¿Por qué a veces $user no es un objeto?
      $ret = '<a title="'.$user.'" href="'.url_for('@usuario?username='.$user->getProfile()->getVanity()).'">'; 
    }

    if( $user && $user->getProfile()->getImagen() ){
    	$ret .= image_tag(S3Voota::getImagesUrl().'/usuarios/cc_s_'.( $user->getProfile()->getImagen()), array('alt' => fullName( $user ), 'width' => $width, 'height' => $height));
    }
    else if ( $user && $user->getProfile()->getFacebookUid()){
      $ret .= jsWrite("fb:profile-pic", array('uid' => $user->getProfile()->getFacebookUid(), 'linked' => 'false', 'size' => 'square', 'facebook-logo' => 'true', 'width' => $width, 'height' => $height ));
    }
  	else {
  		$ret .= image_tag(S3Voota::getImagesUrl().'/usuarios/v.png', array('alt' => fullName( $user ), 'width' => $width, 'height' => $height));
  	}
 
    if ($user) { // FIXME: ¿Por qué a veces $user no es un objeto?
      $ret .= '</a>';
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
    $ret .= jsWrite("fb:profile-pic", array('uid' => $user->getProfile()->getFacebookUid(), 'linked' => 'false', 'size' => 'normal', 'facebook-logo' => 'true' ));
  }
	else {
	  //$ret .= image_tag(S3Voota::getImagesUrl().'/usuarios/no-imago.png', array('alt' => fullName( $user ), 'width' => 180, 'height' => 240));
	  $ret .= image_tag('/images/no-imago.png', array('alt' => fullName( $user ), 'width' => 180, 'height' => 240));
	}

	return $ret;
}

function vo_facebook_connect_button() {
	return "<a class=\"fbconnect_login_button\" href=\"#\">".  image_tag('/sfFacebookConnectPlugin/images/fb_light_medium_short.gif', 'alt="Facebook Connect"') . "</a>";
}

function vo_facebook_connect_ajax_button($box, $func_name) {
  // FIXME: ¿Nos hace falta para algo más que para asociar el usuario? Si no, eliminar
	$func = $func_name.'("'. url_for('@usuario_fb_edit') .'", "'.$box.'")';
	#return "<a id='fbc_button_c' onclick=\"return $func\" href='#'>".  image_tag('/sfFacebookConnectPlugin/images/fb_light_medium_short.gif', 'alt="Facebook Connect"') . "</a>";
	return jsWrite('fb:login-button', array('id' => 'fbc_button_c', 'v' => 2, 'size' => 'medium', 'perms' => 'publish_stream', 'onlogin' => $func), __('Connect'));
}

function vo_facebook_connect_associate_button($text = '', $box = 'facebook-connect') {
  $func = 'facebookAssociate(\''. url_for('@usuario_fb_edit?op=con&box='.$box). '\', \''.$box.'\')';
  return '<a href="#" onclick="javascript:'.$func.'" class="facebook-button"><span>'.__('Sincronizar Voota con Facebook').'</span></a>';
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
	$module = $request->getParameter('module');
	$action = $request->getParameter('action');
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
			if ($module == 'sfReviewFront' && $action == 'show' && $name == 'id'){
				$review = SfReviewPeer::retrieveByPk($request->getParameter('id'));
				$value = SfVoUtil::reviewPermalink( $review, $culture ); 
			}
			$params .= ($params == ""?'?':'&'). "$name=$value";
		}
	}
	$route = sfContext::getInstance()->getController()->genUrl("@$routeName$params");
	
	$host = preg_replace("/\.[a-zA-Z]*$/is", ".".$extensions[$culture], $_SERVER['HTTP_HOST']);
	
	return "http://$host$route";
}

function twName( $user ){
	$data = TwitterManager::verify( $user );
	$ret = "";
	if ($data){
		$ret = "".$data->name. " (@".$data->screen_name.")";
	}
	return $ret;
}
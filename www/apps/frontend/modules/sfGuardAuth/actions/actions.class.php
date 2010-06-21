<?php
 
require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
 
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  private function doSignin($request, $op = '')
  {
  	
    $user = $this->getUser();

    if ($request->isXmlHttpRequest())
    {
      $this->getResponse()->setHeaderOnly(true);
      $this->getResponse()->setStatusCode(401);

      return sfView::NONE;
    }

    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
    $this->form = new $class();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('signin'));
      if ($this->form->isValid())
      {
        $values = $this->form->getValues();
        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

        // always redirect to a URL set in app.yml
        // or to the referer
        // or to the homepage
        $signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer('@homepage'));
        
        if ($op == 'fb'){
        	$this->getUser()->getProfile()->setFacebookUid( sfFacebook::getAnyFacebookUid() );
        	$this->getUser()->getProfile()->save();
        }
        $this->redirect($signinUrl);
      }
    }
    else
    {
      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

      $module = sfConfig::get('sf_login_module');
      if ($this->getModuleName() != $module)
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }
  }
  
  public function executeReminder($request)
  {
    $this->form = new ReminderForm();
    if ( $request->isMethod('post') ) {
      $this->form->bind($request->getParameter('reminder'));
      
      if ($this->form->isValid()) {
      	//$user = sfGuardUserPeer::retrieveByUsername($this->form->getValue('username'));
	    $c = new Criteria();
	    $c->add(sfGuardUserPeer::USERNAME, $this->form->getValue('username'));
	
	    $user = sfGuardUserPeer::doSelectOne($c);
      	if ($user){
		  	$user->getProfile()->setCodigo( util::generateUID() );
		  	$user->getProfile()->save();
      		$this->sendReminder( $user );
      		return "SentSuccess";
      	}
      	else {
      		return "SentFail";
      	}
      }
      /*
      else {
      		$this->getUser()->setFlash('notice_type', 'error', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormNotValidMessage(), false);
      }
      */
    }
    
  }
 
  public function executeChangePassword($request)
  {
  	$this->codigo = $request->getParameter("codigo");  	
	$c = new Criteria();
	$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
	$c->add(SfGuardUserProfilePeer::CODIGO, $this->codigo);
	$user = sfGuardUserPeer::doSelectOne($c);
	
  	$this->forward404Unless($user);
  	
  	$this->form = new PasswordChangeForm();
    //$this->form->bind( array('codigo' => $codigo) );
  	if ( $request->isMethod('post') ) {
  		$this->form->bind($request->getParameter('changer'));
      if ($this->form->isValid()) {
  		$user->setIsActive(1);
		$user->setPassword( $this->form->getValue('passwordNew') );
	  	$user->getProfile()->setCodigo( util::generateUID() );
	  	$user->getProfile()->save();
		$user->save();
  	
       	return "ChangedSuccess";
      }
      /*
      else {
      		$this->getUser()->setFlash('notice_type', 'error', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormNotValidMessage(), false);
      }
      */
    }
  }
 
  public function executeConfirm($request)
  {
  	$codigo = $request->getParameter("codigo");
  	
  	$this->forward404Unless($codigo);

	$c = new Criteria();
	$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
	$c->add(SfGuardUserProfilePeer::CODIGO, $codigo);
	$user = sfGuardUserPeer::doSelectOne($c);
 	
	
  	if ($user) {
		$user->setIsActive(1);
	  	$user->save();
	  	$user->getProfile()->setCodigo( util::generateUID() );
	  	$user->getProfile()->save();
	  	$this->getUser()->signin( $user );
  	}
  }
  
  public function executeUnsubscribe($request)
  {
  	$codigo = $request->getParameter("codigo");
  	$n = $request->getParameter("n");
  	$this->forward404Unless($codigo);
  	$this->forward404Unless($n);
  	
	$c = new Criteria();
	$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
	$c->add(SfGuardUserProfilePeer::CODIGO, $codigo);
	$user = sfGuardUserPeer::doSelectOne($c);
	
  	$this->forward404Unless($user);
  	
  	if ($user) {
  		if ($n == 1){
	  		$user->getProfile()->setMailsComentarios( 0 );
  		}
  		else if ($n == 2){
	  		$user->getProfile()->setMailsContacto( 0 );
  		} 
	  	$user->getProfile()->setCodigo( util::generateUID() );
	  	$user->getProfile()->save();
  	}
	
  }
  
  public function executeSignin($request)
  {
  	$this->op = $request->getParameter('op');
  	$dialog = $request->getParameter('dialog', false);
  	
  	if ($this->op == 'fb' && !$this->getUser()->isAuthenticated()){
  		
  		require_once(sfConfig::get('sf_lib_dir').'/facebook.php');
  		$facebook = new Facebook(array(
  			//api_key_es: f532df1b4d894569787bdda3a28d5b6d
		  'appId' => 'f532df1b4d894569787bdda3a28d5b6d',
		  'secret' => '42b96ac6e0594994d90aba3d2266d853',
		  'cookie' => true,
		));
 	 	$session = $facebook->getSession();
 	 	
		$me = null;
		if ($session) {
			try {
				$uid = $facebook->getUser();
    			$me = $facebook->api('/me');
  			} catch (FacebookApiException $e) {
    			error_log($e);
  			}
		}
		//$facebook_uid = $me['id'];
		
		$c = new Criteria();
		$c->addJoin(SfGuardUserProfilePeer::USER_ID, SfGuardUserPeer::ID);
		$c->add(SfGuardUserProfilePeer::FACEBOOK_UID, $me['id']);
		$sfGuardUser = SfGuardUserPeer::doSelectOne( $c );
		
		$this->getUser()->signin($sfGuardUser, false);
		die;
  	    //$sfGuardUser = self::getGuardAdapter()->getSfGuardUserByFacebookUid($facebook_uid, $isActive);
/*
    	if (!$sfGuardUser instanceof sfGuardUser) {
      		if (sfConfig::get('sf_logging_enabled')) {
        		sfContext::getInstance()->getLogger()->info('{sfFacebookConnect} No user exists with current email hash');
      		}
      		$sfGuardUser = self::getGuardAdapter()->createSfGuardUserWithFacebookUid($facebook_uid);
    	}
    	*/
/*
  		$sfGuardUser = sfFacebook::getSfGuardUserByFacebookSession( FALSE );
  		if ($sfGuardUser){
  			$this->redirect('sfFacebookConnectAuth/signin');
  		}
*/  		
  	}
  	
  	$this->registrationform = new RegistrationForm();
    $this->signinform = new SigninForm();

    if ($request->isMethod('post') && !$dialog){
    	// Register
    	if ($this->op == 'r') {
	      $this->registrationform = new RegistrationForm();    
	      $this->registrationform->bind($request->getParameter('registration'));
	      
	      if ($this->registrationform->isValid()) {
	      	$user = new sfGuardUser();
	      	$user->setUsername($this->registrationform->getValue('username'));
	      	$user->setPassword($this->registrationform->getValue('password'));
	      	$user->setIsActive(0);
	      	$user->setCreatedAt(time());
		  	$c = new Criteria();
		  	$c->add(sfGuardUserPeer::USERNAME, $user->getUsername());
		  	
	      	sfGuardUserPeer::doInsert( $user );
	
		  	$user = sfGuardUserPeer::doSelect( $c );
		  	if (count($user) == 1){
		      	$profile = $user[0]->getProfile();
		     	$profile->setNombre($this->registrationform->getValue('nombre'));
		      	$profile->setApellidos($this->registrationform->getValue('apellidos'));
		      	$profile->setPresentacion($this->registrationform->getValue('presentacion'));
		      	$profile->setCodigo( util::generateUID() );
			    /* Generar vanity */
			    if ($profile->getVanity() == ''){
			    	$vanityUrl = SfVoUtil::encodeVanity($profile->getNombre()."-".$profile->getApellidos()) ;
			    	
				    $c2 = new Criteria();
				    $c2->add(SfGuardUserProfilePeer::VANITY, "$vanityUrl%", Criteria::LIKE);
				    $c2->add(SfGuardUserProfilePeer::ID, $user[0]->getId(), Criteria::NOT_EQUAL);
				    $usuariosLikeMe = SfGuardUserProfilePeer::doSelect( $c2 );
				    $counter = 0;
				    foreach ($usuariosLikeMe as $usuarioLikeMe){
				    	$counter++;
				    }
				    $profile->setVanity( "$vanityUrl". ($counter==0?'':"-$counter") );
			    }
			    /* Fin Generar vanity */   	
		      	sfGuardUserProfilePeer::doInsert( $profile );
		      	
		      	$this->sendWelcome( $user[0] );
		      	
		      	$this->user = $user[0];
		      	
	      		return "Registered";
		  	}
		  }
		  /*
		  else {
      		$this->getUser()->setFlash('notice_type', 'error', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormNotValidMessage(), false);
		  }
		  */
      	}
      	// Signin
      	else { 	
	      $r = new SigninForm();    
	      $r->bind($request->getParameter('signin'));
	      
	      if ($r->isValid()) {
	      	$r->addPostValidation();
	      	$r->bind($request->getParameter('signin'));
		      if ($r->isValid()) {
	  			$this->doSignin($request, $this->op);
		      }
	      }
	      
	      /*
	      else {
      		$this->getUser()->setFlash('notice_type', 'error', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormNotValidMessage(), false);
      	  }
      	  */
	      $this->signinform = $r; 
      	}
    }
  	$this->title = sfContext::getInstance()->getI18N()->__('Acceso usuarios', array());
  	$this->title .= ' - Voota';
  	  	
    $this->response->setTitle( $this->title );
    
    if ($this->op == 'fb'){
    	return 'FB';
    }
  }
  
  private function sendWelcome( $user ){
	  $mailBody = $this->getPartial('mailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  VoMail::send(sfContext::getInstance()->getI18N()->__('Confirmar tu registro Voota'), $mailBody, $user->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'));
  }
  
  private function sendReminder( $user ){
	  $mailBody = $this->getPartial('reminderMailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  VoMail::send(sfContext::getInstance()->getI18N()->__('Tu contraseña en Voota'), $mailBody, $user->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'));
  }
  
  public function executeRemove(sfWebRequest $request)
  {
  	$codigo = $request->getParameter("codigo");
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
  	if ($codigo == ''){
	  	$this->getUser()->getProfile()->setCodigo( util::generateUID() );
	  	$this->getUser()->getProfile()->save();
	  	
	  	$mailBody = $this->getPartial('removeMailBody', array(
		  	'nombre' => $this->getUser()->getProfile()->getNombre(),
		  	'codigo' => $this->getUser()->getProfile()->getCodigo()
	  	));
	  	
	  	$this->email = $this->getUser()->getUsername(); 
	 
	  	VoMail::send(sfContext::getInstance()->getI18N()->__('Borrarse de Voota'), $mailBody, $this->getUser()->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'), false);
   	}
  	else {
		$c = new Criteria();
		$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
		$c->add(SfGuardUserProfilePeer::CODIGO, $codigo);
		$user = sfGuardUserPeer::doSelectOne($c);
		
	  	$this->forward404Unless($user);
  		
	  	SfReviewManager::deleteReviewById( $user->getId() );
	  	$user->delete();
	  	if ($this->getUser()->isAuthenticated()){
	  		$this->getUser()->signOut();
	  	}
	  	
	  	return 'Confirm';
   	}
  }

  public function executeConfirmMerge(){
	if ($this->getUser()->isAuthenticated() && sfFacebook::getFacebookClient()->get_loggedin_user()){
  		// Buscar conflictos: Primero buscar si existe otro usuario con este UID 
  		$c = new Criteria();
  		$c->addJoin(SfGuardUserPeer::ID, SfGuardUserProfilePeer::USER_ID);
  		$c->add(SfGuardUserProfilePeer::FACEBOOK_UID, sfFacebook::getFacebookClient()->get_loggedin_user());
  		$c->add(SfGuardUserProfilePeer::USER_ID, $this->getUser()->getGuardUser()->getId(), Criteria::NOT_EQUAL);
  		$users = SfGuardUserPeer::doSelect( $c );
  		if (count($users) > 0){
	  		$userArray = array();
	  		foreach ($users as $user){
	  			$userArray[] = $user->getId();
		  		// Desactivar
  				$user->setIsActive( false );
  				// Guardar id del usuario canónico en lugar del fb_uid
  				$user->getProfile()->setFacebookUid( $this->getUser()->getGuardUser()->getId() );
  				$user->save();
  				$user->getProfile()->save();
	  		}
	  		// Reasignar opiniones
	  		$selectCriteria = new Criteria();
	  		$selectCriteria->add(SfReviewPeer::SF_GUARD_USER_ID, $userArray, Criteria::IN);
	  		$updateCriteria = new Criteria();
	  		$updateCriteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());
	  		BasePeer::doUpdate($selectCriteria, $updateCriteria, Propel::getConnection());
  		}
  		// FIN: Buscar conflictos
  		
		$sfGuardUser = $this->getUser()->getGuardUser();
	    sfFacebook::getGuardAdapter()->setUserFacebookUid($sfGuardUser, sfFacebook::getFacebookClient()->get_loggedin_user());
	    $sfGuardUser->save();
	    $sfGuardUser->getProfile()->save();
	    
	    //$this->getUser()->signin( $sfGuardUser );
	    $sfGuardUser->getProfile()->setFaceBookUID( sfFacebook::getFacebookClient()->get_loggedin_user() );
	}
	
	$this->forward('sfGuardAuth', 'editFB');
  }
  
  public function executeEditFB(sfWebRequest $request)
  {
  	$op = $request->getParameter("op");
  	$this->box = $request->getParameter("box");
	$sfGuardUser = $this->getUser()->getGuardUser();
  	
  	if ($this->getUser()->isAuthenticated() && $op == 'dis'){
  		$this->getUser()->getProfile()->setFacebookUid(null);
  		$this->getUser()->getProfile()->save();
  	}
	if ($this->getUser()->isAuthenticated() && sfFacebook::getFacebookClient()->get_loggedin_user() && $op == 'con'){
  		// Buscar conflictos: Primero buscar si existe otro usuario con este UID 
  		$c = new Criteria();
  		$c->addJoin(SfGuardUserPeer::ID, SfGuardUserProfilePeer::USER_ID);
  		$c->add(SfGuardUserProfilePeer::FACEBOOK_UID, sfFacebook::getFacebookClient()->get_loggedin_user());
  		$c->add(SfGuardUserProfilePeer::USER_ID, $this->getUser()->getGuardUser()->getId(), Criteria::NOT_EQUAL);
  		$users = SfGuardUserPeer::doSelect( $c );
  		if (count($users) > 0){
  			$this->faceBookUid = sfFacebook::getFacebookClient()->get_loggedin_user();
  			return 'ConfirmMerge';
  		}
  		// FIN: Buscar conflictos
  		
	    sfFacebook::getGuardAdapter()->setUserFacebookUid($sfGuardUser, sfFacebook::getFacebookClient()->get_loggedin_user());
	    $sfGuardUser->save();
	    $sfGuardUser->getProfile()->save();
	    
	    //$this->getUser()->signin( $sfGuardUser );
	    $sfGuardUser->getProfile()->setFaceBookUID( sfFacebook::getFacebookClient()->get_loggedin_user() );
  	}
	  	
   	if ($this->getUser()->isAuthenticated()) {
		$formData = sfGuardUserPeer::retrieveByPk($this->getUser()->getGuardUser()->getId());	
		$this->profileEditForm = new ProfileEditForm( $formData );
		
		if (isset($sfGuardUser)){
		   	$this->lastReview = SfReviewManager::getLastReviewByUserId( $sfGuardUser->getId() );
		   	$this->lastReviewOnReview = SfReviewManager::getLastReviewOnReviewByUserId( $sfGuardUser->getId() );
		}
   	}
	if ($this->box == 'lo_fb_conn'){
		die;
	} 
  }
  
  public function executeEdit(sfWebRequest $request)
  {    
	$this->hasDeepUpdates = false;
	
	$c = new Criteria();
	$c->add(PropuestaPeer::IS_ACTIVE, true);
	$this->propuestasCount = PropuestaPeer::doCount( $c );
	
  	$this->isCanonicalVootaUser = SfVoUtil::isCanonicalVootaUser( $this->getUser()->getGuardUser() );
    
  	if ( $this->getUser()->isAuthenticated() ){
	   	$this->lastReview = SfReviewManager::getLastReviewByUserId( $this->getUser()->getGuardUser()->getId() );
	   	$this->lastReviewOnReview = SfReviewManager::getLastReviewOnReviewByUserId( $this->getUser()->getGuardUser()->getId() );
  	}
   	
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
	
	$formData = sfGuardUserPeer::retrieveByPk($this->getUser()->getGuardUser()->getId());
    
    if(!SfVoUtil::isEmail($formData->getUsername())){
    	$formData->setUsername('');
    }
	
	$this->profileEditForm = new ProfileEditForm( $formData );
	$this->politico = false;
  	$politicos = $this->getUser()->getGuardUser()->getPoliticos();
  	if ( $politicos && count($politicos) != 0){
  		$this->politico = $politicos[0];  		
  		
	  	unset(
	  		$this->profileEditForm['nombre'],
	  		$this->profileEditForm['apellidos']
	  		);
  	}
	$imagenOri = $formData->getProfile()->getImagen();
	
	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());
	$this->numReviews = SfReviewPeer::doCount( $criteria );
	
    if ($request->isMethod('post') ){
    	
    	$this->profileEditForm->bind($request->getParameter('profile'), $request->getFiles('profile'));
      
		if ($this->profileEditForm->isValid()){
			/*if ($this->politico){
			  	$cacheManager = $this->getContext()->getViewCacheManager();
			  	if ($cacheManager != null) {
			  		$politico = $this->getRoute()->getObject();
			    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."");
			  	}				
			}*/
	      	$profile = $request->getParameter('profile');
	    	$this->hasDeepUpdates = ($profile['presentacion'] != $formData->getProfile()->getPresentacion()); 
      		
      		if ($this->profileEditForm->getValue('imagen_delete') != "" ){
      			// Si se elimina la imagen, hay que recargar el formulario para que se refresque
    			$formData->getProfile()->setImagen("");
				$this->profileEditForm = new ProfileEditForm( $formData );
      		}
      		else {
				$imageOri = $this->profileEditForm->getObject()->getProfile()->getImagen();
	      		$imagen = $this->profileEditForm->getValue('imagen');
	      		$this->profileEditForm->save();
	      		if ($imagen){
		      		$arr = array_reverse( explode  ( "."  , $imagen->getOriginalName() ) );
					$ext = strtolower($arr[0]);
					if (!$ext || $ext == ""){
						$ext = "png";
					}      		
		      		$imageName = $this->profileEditForm->getValue('nombre')?$this->profileEditForm->getValue('nombre'):$arr[1];
		      		if ($this->profileEditForm->getValue('apellidos') != '') {
		      			$imageName .= "-". $this->profileEditForm->getValue('apellidos');
		      		}
		      		$imageName .= "-".sprintf("%04d", rand(0, 999));
		      		$imageName .= ".$ext";
		      		$imagen->save(sfConfig::get('sf_upload_dir').'/usuarios/'.$imageName);
		      		$this->profileEditForm->getObject()->getProfile()->setImagen( $imageName );
		      		$this->profileEditForm->setImageSrc( $imageName );
		      		
		      		$this->hasDeepUpdates = true;
	      		}
	      		else {
	      			$this->profileEditForm->getObject()->getProfile()->setImagen( $imagenOri );
		      		$this->profileEditForm->setImageSrc( $imagenOri );
	      		}
      		}
			if ($profile['passwordNew'] != ''){
      			// Check old password
      			if ($this->getUser()->checkPassword($profile['passwordOld'])){
      				$this->getUser()->setPassword($profile['passwordNew']);
      			}
      			else {
      				$this->getUser()->setFlash('notice_type', 'error', false);
      				$this->getUser()->setFlash('notice', sfVoForm::getMissingPasswordMessage(), false);
      				return;
      			}
      		}
      		$this->getUser()->setFlash('notice_type', 'notice', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormSavesMessage(), false);
      		
       		$this->profileEditForm->save();
       		
      		$profile = $this->profileEditForm->getObject()->getProfile();   
		
      		$profile->save();    		
		  	$aText = utf8_decode($this->profileEditForm->getValue('presentacion'));
  			$aText = strip_tags( substr($aText, 0, 280) );
  			$aText = utf8_encode($aText);
      		$profile->setPresentacion( $aText );
      		
		
	    	if ($profile->isColumnModified(SfGuardUserProfilePeer::PRESENTACION)){ 
	    		$this->hasDeepUpdates = true;
	    	}
       		
      		$this->presentacionValue = $aText;
		}
	    else {
      		$this->getUser()->setFlash('notice_type', 'error', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormNotValidMessage(), false);
	    }
    }
    
    if (!$this->presentacionValue){
    	$this->presentacionValue = $this->profileEditForm['presentacion']->getValue(); 
    }
  }
  
  public function executeRemoveTip(sfWebRequest $request)
  {
  	if( $this->getUser()->isAuthenticated()){
  		$this->getUser()->getProfile()->setFbTip(0);
  		$this->getUser()->getProfile()->save();
  	}
  }
}
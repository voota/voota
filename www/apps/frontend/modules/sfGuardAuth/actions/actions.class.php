<?php
 
require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
 
class sfGuardAuthActions extends BasesfGuardAuthActions
{
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
	  	$user->getProfile()->setCodigo( util::generateUID() );
	  	$user->getProfile()->save();
      	if ($user){
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
	  	$user->getProfile()->setMailsComentarios( 0 );
	  	$user->getProfile()->setCodigo( util::generateUID() );
	  	$user->getProfile()->save();
  	}
	
  }
  
  public function executeSignin($request)
  {
    $this->registrationform = new RegistrationForm();
    $this->signinform = new SigninForm();
    if ($request->isMethod('post') ){
    	// Register
    	if ($request->getParameter('op') == 'r') {
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
	  			parent::executeSignin($request);
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
  }
  
  private function sendWelcome( $user ){
	  $mailBody = $this->getPartial('mailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  VoMail::send('Confirmar tu registro Voota', $mailBody, $user->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'));
  }
  
  private function sendReminder( $user ){
	  $mailBody = $this->getPartial('reminderMailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  VoMail::send('Tu contraseña en Voota', $mailBody, $user->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'));
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
	 
	  	VoMail::send('Borrarse de Voota', $mailBody, $this->getUser()->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'), true);
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
  
  public function executeEdit(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
	
	$formData = sfGuardUserPeer::retrieveByPk($this->getUser()->getGuardUser()->getId());
	$this->profileEditForm = new ProfileEditForm( $formData );
	
    if ($request->isMethod('post') ){  
      	$this->profileEditForm->bind($request->getParameter('profile'), $request->getFiles('profile'));
      
		if ($this->profileEditForm->isValid()){
	      	$profile = $request->getParameter('profile');
      		
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
		      		$arr = array_reverse( split("\.", $imagen->getOriginalName()) );
					$ext = strtolower($arr[0]);
					if (!$ext || $ext == ""){
						$ext = "png";
					}      		
		      		$imageName = $this->profileEditForm->getValue('nombre');
		      		if ($this->profileEditForm->getValue('apellidos') != '') {
		      			$imageName .= "-". $this->profileEditForm->getValue('apellidos');
		      		}
		      		$imageName .= "-".sprintf("%04d", rand(0, 999));
		      		$imageName .= ".$ext";
		      		$imagen->save(sfConfig::get('sf_upload_dir').'/usuarios/'.$imageName);
		      		$this->profileEditForm->getObject()->getProfile()->setImagen( $imageName );
		      		$this->profileEditForm->configure();
	      		}
	      		else {
	      			$this->profileEditForm->getObject()->getProfile()->setImagen( $imageOri );
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
      		$this->profileEditForm->getObject()->getProfile()->save();
      		
	    }
	    else {
      		$this->getUser()->setFlash('notice_type', 'error', false);
      		$this->getUser()->setFlash('notice', sfVoForm::getFormNotValidMessage(), false);
      		
	    }
    }
    

  }
}
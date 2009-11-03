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
      	$user = sfGuardUserPeer::retrieveByUsername($this->form->getValue('username'));
      	if ($user){
      		$this->sendReminder( $user );
      		return "SentSuccess";
      	}
      }
      return "SentFail";
    }
    
  }
 
  public function executeChangePassword($request)
  {
  	$codigo = $request->getParameter("codigo");  	
		
  	$this->form = new PasswordChangeForm();
    $this->form->bind( array('codigo' => $codigo) );
    if ( $request->isMethod('post') ) {
      $this->form->bind($request->getParameter('changer'));
      if ($this->form->isValid()) {
		$c = new Criteria();
		$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
		$c->add(SfGuardUserProfilePeer::CODIGO, $this->form->getValue('codigo'));
		$users = sfGuardUserPeer::doSelect($c);		
		$this->forward404Unless(count($users) == 1);
      	foreach ($users as $user){
  			$user->setPassword( $this->form->getValue('password') );
  			sfGuardUserPeer::doUpdate( $user );
 	  	}      
      	return "ChangedSuccess";
      }
    }
  }
 
  public function executeConfirm($request)
  {
  	$codigo = $request->getParameter("codigo");
  	
  	$this->forward404Unless($codigo);

	$c = new Criteria();
	$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
	$c->add(SfGuardUserProfilePeer::CODIGO, $codigo);
	$users = sfGuardUserPeer::doSelect($c);
 	
	$this->forward404Unless(count($users) == 1);
	
  	foreach ($users as $user){
  		$user->setIsActive(1);
  		sfGuardUserPeer::doUpdate( $user );
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
		      	$profile->setCodigo( util::generateUID() );
		      	sfGuardUserProfilePeer::doInsert( $profile );
		      	
		      	$this->sendWelcome( $user[0] );
		      	
		      	$this->user = $user[0];
		      	
	      		return "Registered";
		  	}
		  }
      	}
      	// Signin
      	else {
	      $r = new SigninForm();    
	      $r->bind($request->getParameter('signin'));
	      
	      if ($r->isValid()) {
  			parent::executeSignin($request);
	      }
	      $this->signinform = $r; 
      	}
    }
  }
  
  private function sendWelcome( $user ){
	  $mailBody = $this->getPartial('mailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  //try{
		$smtp = new Swift_Connection_SMTP("smtp.gmail.com", Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
		$smtp->setUsername('no-reply@voota.es');
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		$smtp->setPassword( $smtp_pass );		
		$mailer = new Swift($smtp);
		  
		$message = new Swift_Message('Confirmar tu registro Voota', $mailBody, 'text/html');
		 
		$mailer->send($message, $user->getUsername(), 'no-reply@voota.es');
		$mailer->disconnect();
	  //}
	  //catch (Exception $e){
	  //}
  }
  
  private function sendReminder( $user ){
	  $mailBody = $this->getPartial('reminderMailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  //try{
		$smtp = new Swift_Connection_SMTP("smtp.gmail.com", Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
		$smtp->setUsername('no-reply@voota.es');
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		$smtp->setPassword( $smtp_pass );		
		$mailer = new Swift($smtp);
		  
		$message = new Swift_Message('Tu contraseña en Voota', $mailBody, 'text/html');
		 
		$mailer->send($message, $user->getUsername(), 'no-reply@voota.es');
		$mailer->disconnect();
	  //}
	  //catch (Exception $e){
	  //}
  }
  
  public function executeEdit(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
	
	$formData = sfGuardUserPeer::retrieveByPk($this->getUser()->getGuardUser()->getId());
   	$this->profileEditForm = new ProfileEditForm( $formData );
   	
    if ($request->isMethod('post') ){  
    	//$this->profileEditForm = new ProfileEditForm();
      	$this->profileEditForm->bind($request->getParameter('profile'), $request->getFiles('profile'));
      
		if ($this->profileEditForm->isValid()){
	      	$profile = $request->getParameter('profile');
			if ($profile['passwordNew'] != ''){
      			// Check old password
      			if ($this->getUser()->checkPassword($profile['passwordOld'])){
      				$this->getUser()->setPassword($profile['passwordNew']);
      			}
      			else {
      				$this->getUser()->setFlash('notice', 'Para cambiar la contraseña tienes que escribir la que tienes ahora.');
      				return;
      			}
      		}
      		
			$imageOri = $this->profileEditForm->getObject()->getProfile()->getImagen();
      		$imagen = $this->profileEditForm->getValue('imagen');
      		
      		if ($this->profileEditForm->getValue('imagen_delete') != "" ){
      			$this->profileEditForm->getObject()->getProfile()->setImagen( "" );
      		}
      		else {
	      		//$this->profileEditForm->getObject()->setId($this->getUser()->getGuardUser()->getId());
	      		$this->profileEditForm->save();
	      		if ($imagen){
		      		$arr = array_reverse( split("\.", $imagen->getOriginalName()) );
					$ext = strtolower($arr[0]);
					if (!$ext || $ext == ""){
						$ext = "png";
					}      		
		      		//$nombreArchivo = sha1($archivo->getOriginalName()).$archivo->getExtension($archivo->getOriginalExtension());
		      		$imageName = $this->profileEditForm->getValue('vanity') . ".$ext";
		      		$imagen->save(sfConfig::get('sf_upload_dir').'/usuarios/'.$imageName);
		      		$this->profileEditForm->getObject()->getProfile()->setImagen( $imageName );
		      		$this->profileEditForm->configure();
	      		}
	      		else {
	      			$this->profileEditForm->getObject()->getProfile()->setImagen( $imageOri );
	      		}
      		}      		
      		$this->getUser()->setFlash('notice', 'Se han aplicado los cambios a tu perfil');
      		$this->profileEditForm->getObject()->getProfile()->save();
      		
	    }
    }
	
  }
}
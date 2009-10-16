<?php
 
require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
 
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeReminder($request)
  {
  	
  }
  public function executeReminderSent($request)
  {
  	
  }
  
  public function executeConfirm($request)
  {
  	$codigo = $request->getParameter("codigo");
  	
  	$this->forward404Unless($codigo);

	$c = new Criteria();
	$c->addJoin(SfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
	$c->add(SfGuardUserProfilePeer::CODIGO, $codigo);
	$users = sfGuardUserPeer::doSelect($c);
 	
	$this->forward404Unless(count($users) > 0);
	
  	foreach ($users as $user){
  		$user->setIsActive(1);
  		sfGuardUserPeer::doUpdate( $user );
  	}
  }
  
  public function executeSignin($request)
  {
    $this->registrationform = new RegistrationForm();
    if ($request->isMethod('post') && $request->getParameter('op') == 'r' )
    {
      $this->registrationform = new RegistrationForm();    
      $this->registrationform->bind($request->getParameter('registration'));
      
      if ($this->registrationform->isValid())
      {
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
    else {
  		parent::executeSignin($request);
    }
  }
  
  private function sendWelcome( $user ){
	  $mailBody = $this->getPartial('mailBody', array(
	  	'nombre' => $user->getProfile()->getNombre(), 
	  	"codigo" => $user->getProfile()->getCodigo()
	  ));
	 
	  //try{
		  //$mailer = new Swift(new Swift_Connection_NativeMail());
		$smtp = new Swift_Connection_SMTP("smtp.gmail.com", Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
		$smtp->setUsername('no-reply@voota.es');
		include ("pass.php");
		$mailer = new Swift($smtp);
		  
		$message = new Swift_Message('Confirmar tu registro Voota', $mailBody, 'text/html');
		 
		$mailer->send($message, $user->getUsername(), 'no-reply@voota.es');
		$mailer->disconnect();
	  //}
	  //catch (Exception $e){
		//$mailer->disconnect();
	  //}
  }
  
  public function executeEdit(sfWebRequest $request)
  {
	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
	
   	$this->profileEditForm = new ProfileEditForm(sfGuardUserPeer::retrieveByPk($this->getUser()->getGuardUser()->getId()));
   	
    if ($request->isMethod('post') ){  
    	//$this->profileEditForm = new ProfileEditForm();
      	$this->profileEditForm->bind($request->getParameter('profile'), $request->getFiles('profile'));
      
		if ($this->profileEditForm->isValid()){
			$imageOri = $this->profileEditForm->getObject()->getProfile()->getImagen();
      		$imagen = $this->profileEditForm->getValue('imagen');
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
      		
      		$this->profileEditForm->getObject()->getProfile()->save();
	    }
    }
	
  }
}
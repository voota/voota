<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasesfReviewFront actions.
 *
 * @package    Voota
 * @subpackage oauth
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseSfOauthServerActions extends sfActions
{
  protected function getStore() {
  	return OAuthStore::instance('MySQL', array(
							'server' => sfConfig::get('app_oauth_server')
							, 'username' => sfConfig::get('app_oauth_username')
							, 'password' => sfConfig::get('app_oauth_password')
							, 'database' => sfConfig::get('app_oauth_database')
							)
						); 
  } 

  public function executeRegister(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
	$this->form = new OauthRegisterForm( );
	
    if ( $request->isMethod('post') ) {
      $this->form->bind($request->getParameter('application'));
      if ($this->form->isValid())
      {
		// The currently logged on user
		$user_id = $this->getUser()->getGuardUser()->getId()+1000;
		
		// This should come from a form filled in by the requesting user
		$consumer = array(
		    // These two are required
		    'requester_name' => $this->form['name']->getValue(),
		    'requester_email' => $this->form['email']->getValue(),
		
		    // These are all optional
		    'callback_uri' => $this->form['callback_uri']->getValue(),
		    'application_uri' => $this->form['application_uri']->getValue(),
		    'application_title' => $this->form['application_title']->getValue(),
		    'application_descr' => $this->form['application_descr']->getValue(),
		    'application_notes' => $this->form['application_notes']->getValue(),
		    'application_type' => $this->form['application_type']->getValue(),
		    'application_commercial' => $this->form['application_commercial']->getValue()
		);
		
		// Register the consumer
		$store = OAuthStore::instance('MySQL', array(
								'server' => sfConfig::get('app_oauth_server')
								, 'username' => sfConfig::get('app_oauth_username')
								, 'password' => sfConfig::get('app_oauth_password')
								, 'database' => sfConfig::get('app_oauth_database')
								)
							); 
		$key   = $store->updateConsumer($consumer, $user_id);
		// Get the complete consumer from the store
		$consumer = $store->getConsumer($key, $user_id);
		
		// Some interesting fields, the user will need the key and secret
		$this->consumer = $consumer;
		$this->consumer_id = $consumer['id'];
		$this->consumer_key = $consumer['consumer_key'];
		$this->consumer_secret = $consumer['consumer_secret'];
		
		//$this->list = $store->listConsumers($user_id);
		
		return 'ShowData';
      }
    }
  }
  
  public function executeAuthorize(){
	$store = $this->getStore();
  	$server = new OAuthServer();
  	
  	try
	{
		$server->authorizeVerify();
		$server->authorizeFinish(true, 1);
	}
	catch (OAuthException $e)
	{
		header('HTTP/1.1 400 Bad Request');
		header('Content-Type: text/plain');
		
		echo "Failed OAuth Request: " . $e->getMessage();
	}
  }
  
  public function executeRequestToken(){
	$store = $this->getStore();
  	$server = new OAuthServer();
  	
	$server->requestToken();
  }
  
  public function executeAccessToken(sfWebRequest $request){
	$store = $this->getStore();	
  	$server = new OAuthServer(  );
  	
	$server->accessToken();
  }
  
	private function send ($subject, $mailBody, $to, $from) {
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		
		$mailEnabled = sfConfig::get('sf_mail_enabled');
		$mailServer = sfConfig::get('sf_mail_server');
		$mailPort = sfConfig::get('sf_mail_port');
		$mailUser = sfConfig::get('sf_mail_user');

		if ($mailEnabled == 'on') {		
			$transport = Swift_SmtpTransport::newInstance($mailServer, $mailPort)
                    ->setUsername( $mailUser )
                    ->setPassword( $smtp_pass );
			 		       
			$mailer = Swift_Mailer::newInstance($transport);
			  
			$message = Swift_Message::newInstance( $subject )
						->setCharset('utf-8')
	  					->setFrom( $from )
	  					->setTo( $to )
	  					->setBody( $mailBody, 'text/html', 'utf-8' )
	  					;
	  					
	  		$result = $mailer->send($message);
		}	
	}
}

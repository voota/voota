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
		// The currently logged on user
		$user_id = $this->getUser()->getGuardUser()->getId()+1000;
		
		// This should come from a form filled in by the requesting user
		$consumer = array(
		    // These two are required
		    'requester_name' => 'John Doe',
		    'requester_email' => 'john@example.com',
		
		    // These are all optional
		    'callback_uri' => 'http://www.myconsumersite.com/oauth_callback',
		    'application_uri' => 'http://www.myconsumersite.com/',
		    'application_title' => 'John Doe\'s consumer site',
		    'application_descr' => 'Make nice graphs of all your data',
		    'application_notes' => 'Bladibla',
		    'application_type' => 'website',
		    'application_commercial' => 0
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
		$this->consumer_id = $consumer['id'];
		$this->consumer_key = $consumer['consumer_key'];
		$this->consumer_secret = $consumer['consumer_secret'];
		
		echo $this->consumer_id;
		echo "<br>";
		echo $this->consumer_key;
		echo "<br>";
		echo $this->consumer_secret;
		echo "<br>";
		echo "<pre>";
		var_dump($consumer);
		echo "</pre>";
		
		$this->list = $store->listConsumers($user_id);
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
}

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
  	oauthSecurityManager::storeInstance();
  } 

  public function executeRegister(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
	$this->form = new OauthRegisterForm(  );
	
    if ( $request->isMethod('post') ) {
      $this->form->bind($request->getParameter('application'));
      if ($this->form->isValid())
      {
		// The currently logged on user
		$user_id = $this->getUser()->getGuardUser()->getId();
		
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
		
		$mailBody = $this->getPartial('mailBody', array(
		  	'nombre' => $this->getUser()->getProfile()->getNombre(), 
		  	"consumer" => $consumer
		));
		VoMail::send(
			sfContext::getInstance()->getI18N()->__('Datos del registro de tu aplicación'), 
			$mailBody, 
			$this->getUser()->getGuardUser()->getUsername(), 
			array('no-reply@voota.es' => 'no-reply Voota'),
			true
		);
		
		return 'ShowData';
      }
    }
  }
  
  public function executeAuthorize(sfWebRequest $request){
  	$this->oauth_token = $request->getParameter('oauth_token', '');
  	$this->oauth_callback = $request->getParameter('oauth_callback', '');
  	
  	if (!$this->getUser()->isAuthenticated())
  		$this->getUser()->setAttribute('url_back', 'sfOauthServer/authorize?oauth_callback='.$this->oauth_callback.'&oauth_token='. $this->oauth_token);
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
  	$authorized = $request->getParameter('authorized', '');
  	
	sfContext::getInstance()->getLogger()->debug( "executeAuthorize: authorized: $authorized");
  	
	$store = $this->getStore();
	$server = new OAuthServer();
	
    if ( $request->isMethod('post') ) {
    	if (!$authorized){
			header('HTTP/1.1 401 Not authorized');
			header('Content-Type: text/plain');
			
			sfContext::getInstance()->getLogger()->warning( "Not authorized by user." );
			echo "Not authorized.";
			die;    		
    	}
	  	try
		{
			sfContext::getInstance()->getLogger()->debug( "executeAuthorize: calling authorizeVerify");
			$server->authorizeVerify();
			sfContext::getInstance()->getLogger()->debug( "executeAuthorize: calling authorizeFinish");
			$server->authorizeFinish(true, $this->getUser()->getGuardUser()->getId());
			if ($this->oauth_callback){
				sfContext::getInstance()->getLogger()->info( "Authorized invoking callback." );
				
				header('Location: '. $this->oauth_callback);
				die;
			}
			sfContext::getInstance()->getLogger()->info( "Authorized." );
		}
		catch (OAuthException $e)
		{
			sfContext::getInstance()->getLogger()->err( "Failed OAuth Request: " . $e->getMessage() );
			
			header('HTTP/1.1 400 Bad Request');
			header('Content-Type: text/plain');
			
			echo "Failed OAuth Request: " . $e->getMessage();
			die;    		
		}
    }
  }
  
  public function executeRequestToken(sfWebRequest $request){
  	$store = $this->getStore();
  	$server = new OAuthServer();
  	
	try
	{
		$server->requestToken();
		sfContext::getInstance()->getLogger()->info( "Got request token " );
		die;
	}	
	catch (OAuthException $e)
	{
		sfContext::getInstance()->getLogger()->err( "Request token: OAuth Execption: " . $e->getMessage() );
	}	
	catch (Exception $e)
	{
		sfContext::getInstance()->getLogger()->err( "Request token error: " . $e->getMessage() );
	}	
  }
  
  public function executeAccessToken(sfWebRequest $request){
	$store = $this->getStore();	
  	$server = new OAuthServer(  );
  	
	try
	{
		$server->accessToken();
		sfContext::getInstance()->getLogger()->info( "Got access token " );
		die;
	}	
	catch (OAuthException $e)
	{
		sfContext::getInstance()->getLogger()->err( "Access token: OAuth Execption: " . $e->getMessage() );
	}	
	catch (Exception $e)
	{
		sfContext::getInstance()->getLogger()->err( "Access token error: " . $e->getMessage() );
	}	
  }
}

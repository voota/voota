<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * oauthSecurity Manager.
 *
 * @package    Voota
 * @subpackage OauthPlugin
 * @author     Sergio Viteri
 */
class oauthSecurityManager extends sfBasicSecurityFilter
{
  protected static function sendNotAuthorized() {
  	sfContext::getInstance()->getLogger()->info( "NOT AUTHORIZED." );
  	
	// The request was signed, but failed verification
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: OAuth realm=""');
    header('Content-Type: text/plain; charset=utf8');
    
    die;
  }
  
  public static function checkAuthorized ()
  {
  	sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized 1" );
  	
  	OAuthStore::instance('MySQL', array(
							'server' => sfConfig::get('app_oauth_server')
							, 'username' => sfConfig::get('app_oauth_username')
							, 'password' => sfConfig::get('app_oauth_password')
							, 'database' => sfConfig::get('app_oauth_database')
							)
						); 
 	
	sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized 2" );
						
  	if (OAuthRequestVerifier::requestIsSigned()){
		sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized 3" );
		try {
			sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized verifier" );
	        $req = new OAuthRequestVerifier();
			sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized verify" );
	        $userId = $req->verify();
 			sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized userId: $userId" );
	
	        // If we have an user_id, then login as that user (for this request)
	        if ($userId) {
				$user = SfGuardUserPeer::retrieveByPK($userId);
 				sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized userId: $userId" );
				sfContext::getInstance()->getUser()->signin( $user );
	            
  				sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized userId: $userId" );
			}
		}
	    catch (OAuthException $e) {
			sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized exception" );
			sfContext::getInstance()->getLogger()->info( "Message: "+ $e->getMessage() );
		    $this->sendNotAuthorized();
	    }
	}
	else {
		sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized request not signed" );
		$this->sendNotAuthorized();
	}
  	    
  	sfContext::getInstance()->getLogger()->info( "oauthSecurityManager::checkAuthorized return userId: $userId" );
	return $userId;
  }
}

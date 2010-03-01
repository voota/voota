<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class oauthSecurityManager extends sfBasicSecurityFilter
{
  protected static function sendNotAuthorized() {
	// The request was signed, but failed verification
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: OAuth realm=""');
    header('Content-Type: text/plain; charset=utf8');
    
    die;
  }
  
  public static function checkAuthorized ()
  {
  	OAuthStore::instance('MySQL', array(
							'server' => sfConfig::get('app_oauth_server')
							, 'username' => sfConfig::get('app_oauth_username')
							, 'password' => sfConfig::get('app_oauth_password')
							, 'database' => sfConfig::get('app_oauth_database')
							)
						); 
						
  	if (OAuthRequestVerifier::requestIsSigned()){
		try
	        {
	        	$req = new OAuthRequestVerifier();
	                $user_id = $req->verify();
	
	                // If we have an user_id, then login as that user (for this request)
	                if ($user_id)
	                {
	                	$user = SfGuardUserPeer::retrieveByPK($user_id);
	                	sfContext::getInstance()->getUser()->signin( $user );
	                }
		}
	    catch (OAuthException $e) {
		        $this->sendNotAuthorized();
	    }
	}
	else {
		$this->sendNotAuthorized();
	}
  	    
  }
}

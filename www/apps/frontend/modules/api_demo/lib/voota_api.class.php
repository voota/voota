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
 * @subpackage Api
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class VootaApi{
  const SERVER_URL = "http://dummy.voota.es:81/frontend_dev.php";
  
  /**
   * Class constructor.
   *
   * @see initialize()
   */
  public function __construct() {
  	$databaseArray = array(
		'server' => sfConfig::get('app_oauth_server')
		, 'username' => sfConfig::get('app_oauth_username')
		, 'password' => sfConfig::get('app_oauth_password')
		, 'database' => sfConfig::get('app_oauth_database')
		);
  	
  	OAuthStore::instance(
  		'MySQL', 
  	  	OAuthStore::instance('MySQL', $databaseArray)
	);
  }
  
  public function authenticate($consumerKey, $consumerSecret, $userId, $callbackUri){  
	// Save the server in the the OAuthStore
	$store = OAuthStore::instance();
	try {
		// Create the server	  	
		$server = array(
		    'consumer_key' => $consumerKey,
		    'consumer_secret' => $consumerSecret,
		    'server_uri' => self::SERVER_URL . '/a1/',
		    'signature_methods' => array('HMAC-SHA1', 'PLAINTEXT'),
		    'request_token_uri' => self::SERVER_URL . '/oauth/request_token',
		    'authorize_uri' => self::SERVER_URL . '/oauth/authorize',
		    'access_token_uri' => self::SERVER_URL . '/oauth/access_token'
		);
		$consumer_key = $store->updateServer($server, $userId);
	}
	catch(Exception $e) { }
	
	$token = OAuthRequester::requestRequestToken($consumerKey, $userId);
	
	// Callback to our (consumer) site, will be called when the user finished the authorization at the server
	$callback_uri = "$callbackUri?consumer_key=".rawurlencode($consumerKey).'&usr_id='.intval($userId);
	
	// Now redirect to the autorization uri and get us authorized
	if (!empty($token['authorize_uri']))
	{
	    // Redirect to the server, add a callback to our server
	    if (strpos($token['authorize_uri'], '?'))
	    {
	    	$uri = $token['authorize_uri'] . '&'; 
	    }
	    else
	    {
	    	$uri = $token['authorize_uri'] . '?'; 
	    }
	    $uri .= 'oauth_token='.rawurlencode($token['token']).'&oauth_callback='.rawurlencode($callback_uri);
	}
	else
	{
	    // No authorization uri, assume we are authorized, exchange request token for access token
	   $uri = $callback_uri . '&oauth_token='.rawurlencode($token['token']);
	}
	
	Header("Location: $uri");
	die;
  }
  
  public function finishAuthenticate($consumerKey, $userId, $oauthToken){ 
  	OAuthRequester::requestAccessToken($consumerKey, $oauthToken, $userId);
  }

  public function getPoliticos($userId){
  	// The request uri being called.
	$request_uri = 'http://localhost/frontend_dev.php/api/politicos';
	
	// Parameters, appended to the request depending on the request method.
	// Will become the POST body or the GET query string.
	$params = array(
	           'method' => 'politicos'
	     );
	
	// Obtain a request object for the request we want to make
	$req = new OAuthRequester($request_uri, 'GET', $params);
	
	// Sign the request, perform a curl request and return the results, throws OAuthException exception on an error
	$result = $req->doRequest( $userId );
	
	return json_decode( $result['body'] );
  }
  
  public function getMostRecentlyVoted($userId){
  	// The request uri being called.
	$request_uri = 'http://localhost/frontend_dev.php/a1';
	
	// Parameters, appended to the request depending on the request method.
	// Will become the POST body or the GET query string.
	$params = array(
	           'method' => 'most_recently_voted'
	     );
	
	// Obtain a request object for the request we want to make
	$req = new OAuthRequester($request_uri, 'GET', $params);
	
	// Sign the request, perform a curl request and return the results, throws OAuthException exception on an error
	$result = $req->doRequest( $userId );
	
	return json_decode( $result['body'] );
  }
}
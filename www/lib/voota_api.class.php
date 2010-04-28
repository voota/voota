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
 * @version    1.0
 */

class BadRequestException extends Exception { }
class VootaApi{
  
  /**
   * Class constructor.
   *
   * @see initialize()
   */
  public function __construct($url = 'http://voota.es') {
  	$this->serverUrl = $url;
  	
  	$dbConf = Propel::getConfiguration();
  	$dsn = $dbConf['datasources']['propel']['connection']['dsn'];
  	if (preg_match("/dbname=(.*);host=(.*)$/", $dsn, $matches)){
  		$db = $matches[1];
  		$host = $matches[2];
  	}
  	
  	$databaseArray = array(
		'server' => $host
		, 'username' => $dbConf['datasources']['propel']['connection']['user']
		, 'password' => $dbConf['datasources']['propel']['connection']['password']
		, 'database' => $db
		);
  	
  	OAuthStore::instance(
  		'MySQL', 
  	  	OAuthStore::instance('MySQL', $databaseArray)
	);
  }
  
	/**
	* Authenticate - Asks permission to a user to authorize the application
	*
	* @param string $consumerKey Access key 
	* @param string $secretKey Secret key
	* @param integer $userId A user identificator
	* @param string $callbackUri This url will be called to finish authorization
	* @return void
	*/  
  public function authenticate($consumerKey, $consumerSecret, $userId, $callbackUri){  
	// Save the server in the the OAuthStore
	$store = OAuthStore::instance();
	try {
		// Create the server	  	
		$server = array(
		    'consumer_key' => $consumerKey,
		    'consumer_secret' => $consumerSecret,
		    'server_uri' => $this->serverUrl . '/a1/',
		    'signature_methods' => array('HMAC-SHA1', 'PLAINTEXT'),
		    'request_token_uri' => $this->serverUrl . '/oauth/request_token',
		    'authorize_uri' => $this->serverUrl . '/oauth/authorize',
		    'access_token_uri' => $this->serverUrl . '/oauth/access_token'
		);
		$consumer_key = $store->updateServer($server, $userId);
	}
	catch(Exception $e) { 
		//throw new BadRequestException($e->getMessage());
	}
	
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
  
	/**
	* finishAuthenticate - Should be invoked from callback uri passed to authorize
	*
	* @param string $consumerKey Access key 
	* @param integer $userId A user identificator
	* @param string $oauthToken Token got in call to authorize
	* @return void
	*/  
  public function finishAuthenticate($consumerKey, $userId, $oauthToken){ 
  	OAuthRequester::requestAccessToken($consumerKey, $oauthToken, $userId);
  }

	/**
	* getEntities - Retrives a sorted list of entities
	*
	* @param integer $userId A user identificator
	* @param string $type Type of entities to retrieve: 'politician' or 'party'
	* @param integer $limit Max number of results per page
	* @param integer $page Page number
	* @param string $sort Define order of results: 'positive' (sorted desc by positives votes) 
	* 											or 'negatives'(sorted desc by negatives votes)
	* @return array a list of entities
	*/  
  public function getEntities($userId, $type = 'politician', $limit = 20, $page = 1, $sort = 'positive'){
	$params = array(
	           'method' => 'entities',
	           'type' => $type,
	           'limit' => $limit,
	           'page' => $page,
	           'sort' => $sort,
	     );
	$req = new OAuthRequester($this->serverUrl."/a1", 'GET', $params);
	
	$result = $req->doRequest( $userId );
  
	switch( $result['code'] ){
		case 200:
			return json_decode( $result['body'] );
		case 400:
			throw new BadRequestException('Bad request');
			break;
		default:
			throw new Exception('Error');
	}
  }
  
	/**
	* getEntity - Retrives the entity identified by $id
	*
	* @param integer $userId A user identificator
	* @param string $type Type of the entity to retrieve: 'politician' or 'party'
	* @param integer $id The entity id
	* @param integer $page Page number
	* @return Entity an entity
	*/  
  public function getEntity($userId, $type = 'politician', $id){
	$params = array(
	           'method' => 'entity',
	           'type' => $type,
	           'id' => $id,
	     );
	$req = new OAuthRequester($this->serverUrl."/a1", 'GET', $params);
	
	$result = $req->doRequest( $userId );
  
	switch( $result['code'] ){
		case 200:
			return json_decode( $result['body'] );
		case 400:
			throw new BadRequestException('Bad request');
			break;
		default:
			throw new Exception('Error');
	}
  }
  
	/**
	* search - Searchs entities
	*
	* @param integer $userId A user identificator
	* @param string $q The search string
	* @param string $type Type of the entity to retrieve: 'politician', 'party' or false
	* 						if false, returns entities of any type
	* @param integer $limit Max number of results per page
	* @param integer $page Page number
	* @param string $culture Finds results in this language
	* @return array a list of entities
	*/  
  public function search($userId, $q, $type = false, $limit = 20, $page = 1, $culture = 'es'){
	$params = array(
	           'method' => 'search',
	           'q' => $q,
	           'limit' => $limit,
	           'page' => $page,
	           'culture' => $culture,
	           'type' => $type,
	     );
	$req = new OAuthRequester($this->serverUrl."/a1", 'GET', $params);
	
	$result = $req->doRequest( $userId );
	
	switch( $result['code'] ){
		case 200:
			return json_decode( $result['body'] );
		case 400:
			throw new BadRequestException('Bad request');
			break;
		default:
			throw new Exception('Error');
	}	
  }
  
	/**
	* getTopEntities - Returns the most active entities this week
	*
	* @param integer $userId A user identificator
	* @param integer $limit Max number of results
	* @return array a list of entities
	*/  
  public function getTopEntities($userId, $limit = 6, $includeProposals = false){
	$params = array(
	           'method' => 'top',
	           'limit' => $limit,
	           'proposals' => $includeProposals
		     );
	
	$req = new OAuthRequester($this->serverUrl."/a1", 'GET', $params);
	
	$result = $req->doRequest( $userId );
  
	switch( $result['code'] ){
		case 200:
			return json_decode( $result['body'] );
		case 400:
			throw new BadRequestException('Bad request');
			break;
		default:
			throw new Exception('Error');
	}
  }

	/**
	* getReviews - Gets reviews on an entity.
	*
	* @param integer $userId A user identificator
	* @param integer $entity Id of the entity beeing reviewed
	* @param integer $type Type of the entity to review: 'politician', 'party'
	* @param integer $value Vote: 1 for positive or -1 for negative
	* @param integer $limit Max number of results per page
	* @param integer $page Page number
	* @return void
	*/  
  public function getReviews($userId, $entity, $type, $value = false, $limit = 20, $page = 1){
	$params = array(
	           'method' => 'reviews',
	           'entity' => $entity,
	           'type' => $type,
	           'value' => $value,
	           'page' => $page,
	           'limit' => $limit
	     );
	
	$req = new OAuthRequester($this->serverUrl."/a1", 'GET', $params);
	$result = $req->doRequest( $userId );	

	switch( $result['code'] ){
		case 200:
			return json_decode( $result['body'] );
		case 400:
			throw new BadRequestException('Bad request');
			break;
		default:
			throw new Exception('Error');
	}
  }
  
	/**
	* postReview - Posts a review on an entity.
	*
	* @param integer $userId A user identificator
	* @param integer $entity Id of the entity beeing reviewed
	* @param integer $type Type of the entity to review: 'politician', 'party'
	* @param integer $value Vote: 1 for positive or -1 for negative
	* @param string $text Text of the review itself 
	* @return void
	*/  
  public function postReview($userId, $entity, $type, $value, $text){
	$params = array(
	           'method' => 'review',
	           'entity' => $entity,
	           'type' => $type,
	           'value' => $value,
	           'text' => $text
	     );
	
	$req = new OAuthRequester($this->serverUrl."/a1", 'POST', $params);
	$result = $req->doRequest( $userId );

	switch( $result['code'] ){
		case 200:
			return json_decode( $result['body'] );
		case 400:
			throw new BadRequestException('Bad request');
			break;
		default:
			throw new Exception('Error');
	}
  }
}
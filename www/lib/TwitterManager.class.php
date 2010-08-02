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
 * @subpackage Twitter
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

class TwitterManager {
  	public static function requestAuthorization($user){
	  	$culture = $user->getCulture();
	  	
	  	$connection = new TwitterOAuth(sfConfig::get("app_twitter_api_consumer_key_$culture"), sfConfig::get("app_twitter_api_consumer_secret_$culture"));
		$request_token = $connection->getRequestToken(sfContext::getInstance()->getController()->genUrl("sfReviewFront/sendTwitter", true));
	  	if ($connection->http_code == 200) {
			$twAuthUrl = $connection->getAuthorizeURL($request_token['oauth_token']);
			$user->setAttribute('oauth_token', $request_token['oauth_token'], 'vo/twitter');
			$user->setAttribute('oauth_token_secret', $request_token['oauth_token_secret'], 'vo/twitter');
			
			return $twAuthUrl; 
		}
		else {
			throw new Exception('Connection failed!');
		}
  	}
  	
  	public static function verify($user){  		
	  	$culture = $user->getCulture();
  		$profile = $user->getGuardUser()->getProfile();
	  	
  		$connection = new TwitterOAuth(sfConfig::get("app_twitter_api_consumer_key_$culture"), sfConfig::get("app_twitter_api_consumer_secret_$culture"), $profile->getTwOauthToken(), $profile->getTwOauthTokenSecret());
  		$content = $connection->get('account/verify_credentials');
  		if( isset($content->error) && $content->error ){
  			return false;
  		}
  		
  		return $content;
  	}
  	
  	public static function authorize($user, $accessToken){  
	  	$culture = $user->getCulture();
  		$profile = $user->getGuardUser()->getProfile();
  						
  		$connection = new TwitterOAuth(sfConfig::get("app_twitter_api_consumer_key_$culture"), sfConfig::get("app_twitter_api_consumer_secret_$culture"), $user->getAttribute('oauth_token', false, 'vo/twitter'), $user->getAttribute('oauth_token_secret', false, 'vo/twitter'));
		$accessToken = $connection->getAccessToken($accessToken);
		if ($connection->http_code == 200){
			$profile->setTwOauthToken($accessToken['oauth_token']);
			$profile->setTwOauthTokenSecret($accessToken['oauth_token_secret']);
			$profile->save();
		    $user->setAttribute('oauth_token', false, 'vo/twitter');
		    $user->setAttribute('oauth_token_secret', false, 'vo/twitter');
		}
  	}
  	
  	public static function post($user, $text){  
	  	$culture = $user->getCulture();
  		$profile = $user->getGuardUser()->getProfile();
  		
  		$connection = new TwitterOAuth(sfConfig::get("app_twitter_api_consumer_key_$culture"), sfConfig::get("app_twitter_api_consumer_secret_$culture"), $profile->getTwOauthToken(), $profile->getTwOauthTokenSecret());
  		
  		$connection->post('statuses/update', array('status' => $text));
  	}
  	
  	public static function shorten($url){  
  		$entityUrl = $url;
  		
  		$login = sfConfig::get("app_bitly_login");
  		$key = sfConfig::get("app_bitly_key");
  		$url = urlencode  (  $entityUrl  );
  		$shortenerUrl = "http://api.bit.ly/v3/shorten?login=$login&apiKey=$key&longUrl=$url&format=json";
  		$shorted = json_decode( file_get_contents( $shortenerUrl ) );
  		if ($shorted->status_code == 200){
  			$entityUrl = $shorted->data->url;
  		}
  		
  		return $entityUrl;
  	}
}
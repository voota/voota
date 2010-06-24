<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(sfConfig::get('sf_lib_dir').'/facebook.php');

/**
 * Facebook actions.
 *
 * @package    Voota
 * @subpackage Faebook
 * @author     Sergio Viteri
 */
class VoFacebook {	
	public static function getUid() {
		$culture = sfContext::getInstance()->getUser()->getCulture();
		$facebook_uid = false;
		
	  	$facebook = new Facebook(array(
		  'appId' => sfConfig::get("app_facebook_api_id_$culture"),
		  'secret' => sfConfig::get("app_facebook_api_secret_$culture"),
		  'cookie' => true,
		));
	  	$session = $facebook->getSession();
	  	
		$me = null;
		if ($session) {
			try {
				$uid = $facebook->getUser();
	    		//$me = $facebook->api('/me');
	
				$facebook_uid = $uid;
			
	  		} catch (FacebookApiException $e) {
	    		error_log($e);
	  		}
		}
		
		return $facebook_uid;
	}
	
	public static function remove_cookie() {
	  $culture = sfContext::getInstance()->getUser()->getCulture();
	  $app_id = sfConfig::get("app_facebook_api_id_$culture");
	  $application_secret = sfConfig::get("app_facebook_api_secret_$culture");
	  
	  if(isset($_COOKIE['fbs_' . $app_id])){
	  	sfContext::getInstance()->getUser()->setFlash('fb_rm', '1');
	  	unset($_COOKIE['fbs_' . $app_id]);
	  }
	}
	
	public static function get_facebook_cookie() {
	  $culture = sfContext::getInstance()->getUser()->getCulture();
	  $app_id = sfConfig::get("app_facebook_api_id_$culture");
	  $application_secret = sfConfig::get("app_facebook_api_secret_$culture");
	  $fb_rm = sfContext::getInstance()->getUser()->getFlash('fb_rm', false);
	  
	  $args = array();
	  if ($fb_rm){
	  	unset($_COOKIE['fbs_' . $app_id]);
	  }
	  if(isset($_COOKIE['fbs_' . $app_id]) && ($cookie = $_COOKIE['fbs_' . $app_id]) && !$fb_rm){
		  parse_str(trim($cookie, '\\"'), $args);
		  ksort($args);
		  $payload = '';
		  foreach ($args as $key => $value) {
		    if ($key != 'sig') {
		      $payload .= $key . '=' . $value;
		    }
		  }
		  if (md5($payload . $application_secret) != $args['sig']) {
		    return null;
		  }
	  }
	  return $args;
	}
	
}

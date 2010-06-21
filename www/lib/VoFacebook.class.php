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
		$facebook_uid = false;
		
	  	$facebook = new Facebook(array(
		  'appId' => sfConfig::get('app_facebook_api_key'),
		  'secret' => sfConfig::get('app_facebook_api_secret'),
		  'cookie' => true,
		));
	  	$session = $facebook->getSession();
	  	
		$me = null;
		if ($session) {
			try {
				$uid = $facebook->getUser();
	    		$me = $facebook->api('/me');
	
				$facebook_uid = $me['id'];
			
	  		} catch (FacebookApiException $e) {
	    		error_log($e);
	  		}
		}
		
		return $facebook_uid;
	}
}

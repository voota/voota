<?php 
/**
 * sfResizedFile represents a resized uploaded file.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Malas
 * @version    0.1
 */
class sfVoActions extends sfActions
{
  protected function readCookie( $request ) {
  	global $culture;
  	global $uid;
  	global $first;
  	
  	// Si no viene el idioma en la url
  	// 1: Cookie 
	if ($cookie = $request->getCookie('voota')){
		$value = unserialize(base64_decode($cookie));
		
		$uid =  $value[0];
		$culture = $value[1];
		$first = false;
	}
	else {
	  	// 2: Idioma del navegador 
	  	$culture = $request->getPreferredCulture(array('es', 'ca'));
	  	$uid = util::generateUID();
	  	$value[0] = $uid;
	  	$value[1] = $culture;
	  	$cookie = base64_encode(serialize($value));
	  	$this->getResponse()->setCookie('voota', $cookie, time()+60*60*24* 60);
		$first = true;
	}
  }
}
<?php

/**
 * politico actions.
 *
 * @package    sf_sandbox
 * @subpackage politico
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class homeActions extends sfActions{
  var $uid;
  var $culture;
  var $first;
  
  private function readCookie( $request ) {
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
	  	$culture = $request->getPreferredCulture(array('es', 'ca', 'en'));
	  	$uid = util::generateUID();
	  	$value[0] = $uid;
	  	$value[1] = $culture;
	  	$cookie = base64_encode(serialize($value));
	  	$this->getResponse()->setCookie('voota', $cookie, time()+60*60*24* 60);
		$first = true;
	}
  }
	
  public function executeIndexWithoutCulture(sfWebRequest $request) {
  	global $culture;
  	
	$this->readCookie($this->getRequest());
  	$this->redirect( "/$culture" );
  }
  
  public function executeIndex(sfWebRequest $request) {
  	global $uid;
  	global $first;
  	
  	$this->readCookie($this->getRequest());
  	
	$this->main_slot = "feedback";	
  	
  	# returning user ?
  	$criteria = new Criteria();
  	$criteria->add(VotoPeer::UID, $uid);  	
  	$voto = VotoPeer::doSelect($criteria);
  	if (!$voto) {
  		$v = $this->request->getParameter("v");
  		# valid vote?
	  	if ((!$first) && $v && ($v == 1 || $v == 2)){
  			$voto = new Voto();
  			$voto->setUid( $uid );
  			$voto->setValor( $v - 1 );
  			
  			VotoPeer::doInsert( $voto );
	  	}
	  	else {
	  		$this->main_slot = "hands";
	  	}
   	}
  
  	
  	$this->getResponse()->setTitle("Voota. Tú tienes la última palabra", false);
  	
  	
  }
}

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
  public function executeIndexWithoutCulture(sfWebRequest $request) {
  	// Si no viene el idioma en la url
  	// 1: Cookie 
	if ($vootaCookie = $request->getCookie('voota')){
		$culture = $vootaCookie;
	}
	else {
	  	// 2: Idioma del navegador 
	  	$culture = $request->getPreferredCulture(array('es', 'ca', 'en'));
  		# $this->getResponse()->setCookie('voota', $culture);
	}
	  	  	
  	$this->redirect( "/$culture" );
  }
  
  public function executeIndex(sfWebRequest $request) {
  }
}

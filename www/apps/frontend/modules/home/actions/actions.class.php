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
class homeActions extends sfActions{
  public function executeIndexWithoutCulture(sfWebRequest $request) {
  	//global $culture;  	
  	
	//$this->readCookie($this->getRequest());
  	//$this->getUser()->setCulture( $culture );
  	
	$this->redirect( "@homepage" );
  	
  }
  
  public function executeRedir(sfWebRequest $request) {
  	$this->redirect( "@homepage" );
  }
  
  public function executeIndex(sfWebRequest $request) {
  	$lang = $request->getParameter("l");
  	if ($lang != ''){
  		
  	}
  	
  	$urlBack = $this->getUser()->getAttribute('url_back');
  	if ($urlBack && $urlBack != '') {
		$this->getUser()->setAttribute('url_back', '');
	  	if ($this->getUser()->isAuthenticated()) {
  			$this->redirect( $urlBack );
	  	}
	}

  	//$this->redirect( "politico/ranking" );
  	
  	//$this->readCookie($this->getRequest());
  	
	$this->main_slot = "feedback";	
  	  	
  	$this->getResponse()->setTitle("Voota. ". $this->getContext()->getI18N()->__('Tú tienes la última palabra'), false);
  	
  	
  }
}

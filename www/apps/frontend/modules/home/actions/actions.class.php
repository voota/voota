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
  	$this->redirect( "politico/ranking" );
  	# "politico/ranking".$this->getContext()->getI18N()->__($text, $args, 'politicos')	
  }
  
  public function executeIndex(sfWebRequest $request) {
  	global $uid;
  	global $first;
  	
  	$this->redirect( "politico/ranking" );
  	
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
			$con = sfContext::getInstance()->getDatabaseConnection('propel'); 
			$query = 'SELECT COUNT(*) AS total, SUM(VALOR) AS valor FROM voto';
			$stmt = $con->prepare($query);
			$stmt->execute();
			while($row = $stmt->fetch()) {
				$total_up = $row[1];
				$total = $row[0];
				
				if ($total != 0) {
					$this->up_per = round (100 * $total_up / $total);
				}
				else {
					$this->up_per = 0;
				}
				$this->down_per = 100 - $this->up_per;  
  			}
			
	  		
	  		$this->main_slot = "hands";
	  	}
   	}
   	$this->getContext()->getRequest()->setAttribute('langLink_slot', "langLink_".$this->request->getParameter("sf_culture"));
  	
  	$this->getResponse()->setTitle("Voota. ". $this->getContext()->getI18N()->__('Tú tienes la última palabra'), false);
  	
  	
  }
}

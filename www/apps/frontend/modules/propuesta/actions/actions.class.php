<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * propuestas actions.
 *
 * @package    Voota
 * @subpackage propuesta
 * @author     Sergio Viteri
 */

class propuestaActions extends sfActions
{
  public function executeRanking(sfWebRequest $request)
  {
  	$p = $request->getParameter("p");
  	$culture = $this->getUser()->getCulture("es");
  	$page = $request->getParameter("page", 1);
	$this->order = $request->getParameter("o", "pd");
	
  	$this->propuestasPager = EntityManager::getPropuestas($culture, $page, $this->order, EntityManager::PAGE_SIZE, &$totalUp, &$totalDown);    
    $this->totalUp = $totalUp;
    $this->totalDown = $totalDown;    
  	
	$rule = sfContext::getInstance()->getRouting()->getCurrentRouteName();
  	$params = "";
  	foreach ($request->getParameterHolder()->getAll() as $name => $value){
  		if ($name != 'module' && $name != 'action' && $name != 'o' && $name != 'page'){
  			if ($params === ""){
  				$params .= "?";
  			}
  			else {
  				$params .= "&";
  			}
  			$params .= "$name=$value";
  		}
  	}
  	$this->route = "propuesta/ranking$params";
  	
  	$this->pageTitle = sfContext::getInstance()->getI18N()->__('Ranking de propuestas', array());
  	if ($this->order != 'pd') {
  		switch($this->order){
  			case 'pa':
  				$orderTxt = sfContext::getInstance()->getI18N()->__('votos positivos inverso');
  				break;
  			case 'nd':
  				$orderTxt = sfContext::getInstance()->getI18N()->__('votos negativos');
  				break;
  			case 'na':
  				$orderTxt = sfContext::getInstance()->getI18N()->__('votos negativos inverso');
  				break;
  		}
  		$this->pageTitle .= ", $orderTxt";
   	}
  	if ($page && $page != 1) {
  		$this->pageTitle .= " ".sfContext::getInstance()->getI18N()->__('(Pág. %1%)', array('%1%' => $page));
  	}
  	$this->title = $this->pageTitle . ' - Voota';
  	
  	$description = sfContext::getInstance()->getI18N()->__('Ranking de políticos', array());
  	if (isset($aaPartido)){
  		if ($this->partido != '0' && $aaPartido) {
	  		$description .= ", " . $aaPartido->getNombre();
   		}
	  	if ($this->institucion != '0') {
	  		$description .= ", " . $aInstitucion->getNombre()." (". $aInstitucion->getGeo()->getNombre() .", España)";
   		}
  	}
  	if ($this->order != 'pd') {
  		switch($this->order){
  			case 'pa':
  				$orderTxt = sfContext::getInstance()->getI18N()->__('votos positivos inverso');
  				break;
  			case 'nd':
  				$orderTxt = sfContext::getInstance()->getI18N()->__('votos negativos');
  				break;
  			case 'na':
  				$orderTxt = sfContext::getInstance()->getI18N()->__('votos negativos inverso');
  				break;
  		}
  		$description .= ", $orderTxt";
   	}
  	if ($page && $page != 1) {
  		$description .= " ".sfContext::getInstance()->getI18N()->__('(Pág. %1%)', array('%1%' => $page));
  	}
  	$this->response->addMeta('Description', $description);
  	
  	
    $this->response->setTitle( $this->title );
  }
  
  public function executeNew(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  }
  
  public function executeShow(sfWebRequest $request)
  {
  	$id = $this->request->getParameter("id");
  	
  	$propuesta = PropuestaPeer::retrieveByPk( $id );
  	$this->forward404Unless( $propuesta );
  }
}

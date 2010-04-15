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
  	
  	$description = sfContext::getInstance()->getI18N()->__('Ranking de propuestas', array());
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
  	
  	$this->form = new NuevaPropuestaForm();
  	
  }
  
  public function executeShow(sfWebRequest $request)
  {  	  	  	
  	$id = $request->getParameter('id');
  	$s = $request->getParameter('s', 0);
  	
  	$culture = $this->getUser()->getCulture();
  	  	
  	$this->propuesta = PropuestaPeer::retrieveByPk( $id );
  	$this->forward404Unless( $this->propuesta );
	
  	$exclude = array();
  	
	$this->positives = SfReviewManager::getReviewsByEntityAndValue($request, Propuesta::NUM_ENTITY, $id, 1);
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue($request, Propuesta::NUM_ENTITY, $id, -1);
	$positiveCount =  $this->positives->getNbResults();
	$negativeCount =  $this->negatives->getNbResults();
	
	$this->totalCount = $positiveCount + $negativeCount;
	if ($this->totalCount > 0) {
		$this->positivePerc = intval( $positiveCount * 100 / $this->totalCount );
		$this->negativePerc = 100 - $this->positivePerc;
	}  
	else {
		$this->positivePerc = 0;
		$this->negativePerc = 0;
	}
  	$this->title = sfContext::getInstance()->getI18N()->__('%1%, opiniones a favor y en contra en Voota'
  					, array(
  						'%1%' => $this->propuesta->getTitulo()
  					)
  	);
  	
  	$description = sfContext::getInstance()->getI18N()->__('Página de %1%', array('%1%' => $this->propuesta->getTitulo()));
  	$description .= sfContext::getInstance()->getI18N()->__('%1% votos a favor y %2% votos en contra.', array('%1%' => $positiveCount, '%2%' => $negativeCount));
    $this->response->addMeta('Description', $description);
  	
    $this->response->setTitle( $this->title );
    
    // Enlaces
    /*
    $c = new Criteria();
	$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
	$c->add( $rCriterion );
	if ($politico->getsfGuardUser()){
		$c->add(EnlacePeer::SF_GUARD_USER_ID, $politico->getsfGuardUser()->getId());
	}
	else {
		$c->add(EnlacePeer::POLITICO_ID, $id);
	}
	$c->add(EnlacePeer::URL, '', Criteria::NOT_EQUAL);
    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    $this->twitterUser = FALSE;
    foreach ($this->activeEnlaces as $enlace){
    	if (preg_match("/twitter\.com\/(.*)$/is", $enlace->getUrl(), $matches)){
    		$this->twitterUser = $matches[1];
    		break;
    	}
    }
    */
    
    /* Si paginador 
    $this->politicosPager = false;
  	$filter = $this->getUser()->getAttribute('filter', false);
  	if ($filter){
  		if ($s != 0){
  			$filter['page'] += $s;
  			$this->getUser()->setAttribute('filter', $filter);
  			$this->redirect('politico/show?id='.$politico->getVanity());
  		}
	  	$this->politicosPager = EntityManager::getPoliticos($filter['partido'], $filter['institucion'], $filter['culture'], $filter['page'], $filter['order']);
  	}
     paginador */
    
  }
}

<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * partido actions.
 *
 * @package    Voota
 * @subpackage partido
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

define("ALL_FORM_VALUE", '0');

class partidoActions extends sfActions
{
	
  public function executeMoreComments(sfWebRequest $request)
  {
  	$id = $request->getParameter("id");
  	$this->t = $request->getParameter("t");
  	$exclude = array();
  	if ($this->t == 1) {
  		$this->lastPositives = SfReviewManager::getLastReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, 1, 3);
	    foreach ($this->lastPositives->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}	  		
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, 1, BaseSfReviewManager::NUM_REVIEWS-3, $exclude);
  		$this->pageU = $request->getParameter("pageU")+1;
  		$this->getUser()->setAttribute('pageU', $this->pageU);
  	}
  	else {	  	
  		$this->lastNegatives = SfReviewManager::getLastReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, -1, 3);
  		foreach ($this->lastNegatives->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, -1, BaseSfReviewManager::NUM_REVIEWS-3, $exclude);
  		$this->pageD = $request->getParameter("pageD")+1;
  		$this->getUser()->setAttribute('pageD', $this->pageD);
  	}
  	$this->partido = PartidoPeer::retrieveByPK( $id );
  }
  
  public function executeRanking(sfWebRequest $request)
  {
  	$institucion = $request->getParameter("institucion");
  	
  	$c = new Criteria();
  	$c->addJoin(PartidoPeer::ID, PoliticoPeer::PARTIDO_ID, Criteria::INNER_JOIN);
  	$c->addJoin(PoliticoPeer::ID, PoliticoInstitucionPeer::POLITICO_ID, Criteria::INNER_JOIN);
  	$c->addJoin(PoliticoInstitucionPeer::INSTITUCION_ID, InstitucionPeer::ID, Criteria::INNER_JOIN);
  	$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID, Criteria::INNER_JOIN);
  	$c->setDistinct();
  	$c->add(PartidoPeer::ABREVIATURA, null, Criteria::ISNOTNULL);
  	$c->add(PartidoPeer::IS_ACTIVE, true);
  	$this->institucion = ALL_FORM_VALUE;
  	
  	/* Orden de resultados
  	 * pa: positivos ascendente
  	 * pd: positivos descendente
  	 * na: negativos ascendente
  	 * nd: negativos descendente
  	 */
  	$o = $request->getParameter("o");
  	if (!$o){
  		$o = "pd";
  	}
  	if ($o == "pa"){
  		$c->addAscendingOrderByColumn(PartidoPeer::SUMU);
  	}
  	else if ($o == "pd") {
  		$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
  		$c->addAscendingOrderByColumn(PartidoPeer::SUMD);
  	}
  	else if ($o == "na"){
  		$c->addAscendingOrderByColumn(PartidoPeer::SUMD);
  	}
  	else if ($o == "nd") {
  		$c->addDescendingOrderByColumn(PartidoPeer::SUMD);
  		$c->addAscendingOrderByColumn(PartidoPeer::SUMU);
  	}
  	$this->order = $o;
  	/* Fin Orden */
  	
	/* Calcula totales. Ver impacto en rendimiento */
    $allPartidos = PartidoPeer::doSelect( $c );    
    $this->totalUp = 0;
    $this->totalDown = 0;
    foreach ($allPartidos as $aPartido){
	    	$this->totalUp += $aPartido->getSumu();
    	$this->totalDown += $aPartido->getSumd();
    }
	/* Fin Calcula totales */  
    	
  	if ($institucion){
  		$this->institucion = $institucion; 
  		$c->add(InstitucionI18nPeer::VANITY, $this->institucion);
  		
  		$aInstitucionCriteria = new Criteria();
		$aInstitucionCriteria->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
  		$aInstitucionCriteria->add(InstitucionI18nPeer::VANITY, $this->institucion);
  		$aInstitucion = InstitucionPeer::doSelectOne($aInstitucionCriteria);
  	}
  	$pager = new sfPropelPager('Partido', 20);
  	
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->forward404Unless( $pager->getNbResults() != 0 );
    
    $this->partidosPager = $pager;
    
    /* Lista de instituciones */ 
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
  	$this->instituciones = InstitucionPeer::doSelect($c);
  	/*  Fin Lista de instituciones */
  	
  	$rule = sfContext::getInstance()->getRouting()->getCurrentRouteName();
  	$params = "";
  	foreach ($request->getParameterHolder()->getAll() as $name => $value){
  		if ($name != 'module' && $name != 'action'){
  			if ($params === ""){
  				$params .= "?";
  			}
  			else {
  				$params .= "&";
  			}
  			$params .= "$name=$value";
  		}
  	}
  	$this->route = "@$rule$params";
  	
  	$this->pageTitle = sfContext::getInstance()->getI18N()->__('Ranking de partidos', array());
  	$this->pageTitle .= $this->institucion=='0'?'':", " . $aInstitucion->getNombre();
  	$this->title = $this->pageTitle . ' - Voota';
  	$this->response->addMeta('Title', $this->title);
  	
  	$description = sfContext::getInstance()->getI18N()->__('Los partidos más votados en Voota:', array()) . " ";
  	if ($this->partidosPager->getNbResults() > 0){
  		foreach ($this->partidosPager->getResults() as $idx => $partido){
  			if ($idx < 5){
  				$description .= ($idx==0?"":", ") . $partido->getAbreviatura();	
  			}  			
  		}
  	}
  	$this->response->addMeta('Description', $description);
  }

  public function executeShow(sfWebRequest $request)
  {
  	$abreviatura = $request->getParameter('id');
  	$this->institucion = $request->getParameter("institucion");
  	if ($this->institucion == ''){
  		$this->institucion = "0";
  	}
    
  	$c = new Criteria();
  	$c->add(PartidoPeer::ABREVIATURA, $abreviatura , Criteria::EQUAL);
  	$this->partido = PartidoPeer::doSelectOne( $c );
  	
  	$this->forward404Unless( $this->partido );
  	
  	// Estabamos vootando antes del login ?
  	$v = $this->getUser()->getAttribute('review_v');
  	if ($v && $v != ''){
  		$e = $this->getUser()->getAttribute('review_e');
  		$this->getUser()->setAttribute('review_v', '');
  		$this->getUser()->setAttribute('review_e', '');
  		
  		if ($e == $this->partido->getId() && $this->getUser()->isAuthenticated()) {
  			$this->review_v = $v;
  		}	
  	}
  	
  	if ($this->partido->getImagen() != ''){
  		$imageFileName = $this->partido->getImagen();
  	}
  	else {
  		$imageFileName = "p_unknown.png";
   	}
	
	$this->image = "cc_$imageFileName";
  	
	$pu = $this->getUser()->getAttribute('pageU');
	$pd = $this->getUser()->getAttribute('pageD');
	$c = $this->getUser()->getAttribute('review_c');
	if ($c != '' && $pu != ''){
		$resU = BaseSfReviewManager::NUM_REVIEWS * ($pu-1);
		$this->pageU = $pu;
	}
	else {
		$resU = BaseSfReviewManager::NUM_REVIEWS;
		$this->pageU = 2;
	}	
	if ($c != '' && $pd != ''){
		$resD = BaseSfReviewManager::NUM_REVIEWS * ($pd-1);
		$this->pageD = $pd;		
	}
	else {
		$resD = BaseSfReviewManager::NUM_REVIEWS;
		$this->pageD = 2;		
	}	
  	
  	$id = $this->partido->getId();
  	$exclude = array();
	$this->lastPositives = SfReviewManager::getLastReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, 1, 3);
	$this->lastNegatives = SfReviewManager::getLastReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, -1, 3);
    foreach ($this->lastPositives->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
	$this->positives = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, 1, $resU-3, $exclude);
    foreach ($this->lastNegatives->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, -1, $resD-3, $exclude);
	$positiveCount =  $this->lastPositives->getNbResults();
	$negativeCount =  $this->lastNegatives->getNbResults();
	
  	$this->getUser()->setAttribute('pageU', '');
  	$this->getUser()->setAttribute('pageD', '');
	
	$totalCount = $positiveCount + $negativeCount;
	if ($totalCount > 0) {
		$this->positivePerc = intval( $positiveCount * 100 / $totalCount );
		$this->negativePerc = 100 - $this->positivePerc;
	}  
	else {
		$this->positivePerc = 0;
		$this->negativePerc = 0;
	}
  	
  	
    $this->activeEnlaces = array();
    foreach($this->partido->getEnlaces() as $enlace) {
    	if ($enlace->getCulture() == null || $enlace->getCulture() == $this->getUser()->getCulture()){
    		$this->activeEnlaces[] = $enlace;
    	}	
    }
    
    // Politicos mas votados
    $c = new Criteria();
  	$c->add(PoliticoPeer::VANITY, null, Criteria::ISNOTNULL);
  	$c->add(PoliticoPeer::PARTIDO_ID, $this->partido->getId());
  	$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	
  	$this->politicos = new sfPropelPager('Politico', 6);
  	
    $this->politicos->setCriteria($c);
    $this->politicos->init();
    
 	// Lista de instituciones 
  	$c = new Criteria();
  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID);
  	$c->add(PoliticoPeer::PARTIDO_ID, $this->partido->getId());
  	$c->add(InstitucionPeer::DISABLED, 'N');
  	$c->setDistinct();
  	$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
  	$this->instituciones = InstitucionPeer::doSelect($c);
    
  }
}

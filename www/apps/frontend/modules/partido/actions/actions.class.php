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
  	$this->institucion = ALL_FORM_VALUE;
  	
  	if ($institucion && $institucion != ALL_URL_STRING){
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
    
    $this->partidoPager = $pager;
  }

  public function executeShow(sfWebRequest $request)
  {
  	$abreviatura = $request->getParameter('id');
    
  	$c = new Criteria();
  	$c->add(PartidoPeer::ABREVIATURA, $abreviatura , Criteria::EQUAL);
  	$this->partido = PartidoPeer::doSelectOne( $c );
  	
  	$this->forward404Unless( $this->partido );
  	
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
  }
}

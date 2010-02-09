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
define("ALL_URL_STRING", 'all');
define("ALL_FORM_VALUE", '0');

class politicoActions extends sfActions
{
	
  public function executeMoreComments(sfWebRequest $request)
  {
  	$id = $request->getParameter("id");
  	$this->t = $request->getParameter("t");
  	$exclude = array();
  	if ($this->t == 1) {
  		$this->lastPositives = SfReviewManager::getLastReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, 1, 3);
	    foreach ($this->lastPositives->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}	  		
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, 1, BaseSfReviewManager::NUM_REVIEWS-3, $exclude);
  		$this->pageU = $request->getParameter("pageU")+1;
  		$this->getUser()->setAttribute('pageU', $this->pageU);
  	}
  	else {	  	
  		$this->lastNegatives = SfReviewManager::getLastReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, -1, 3);
  		foreach ($this->lastNegatives->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, -1, BaseSfReviewManager::NUM_REVIEWS-3, $exclude);
  		$this->pageD = $request->getParameter("pageD")+1;
  		$this->getUser()->setAttribute('pageD', $this->pageD);
  	}
  	$this->politico = PoliticoPeer::retrieveByPK( $id );
  }
	
  public function executeIndex(sfWebRequest $request)
  {
    $this->politico_list = PoliticoPeer::doSelect(new Criteria());
  }
  
  private function generateRankingUrl ($partido, $institucion, $p = ''){
  	$p_url = "";
  	$i_url = "";
  	$culture = $this->getUser()->getCulture();
  	
  	if ($p != '' && $p != ALL_FORM_VALUE){
  		$p_url .= "$p";
  	}
  	else if ($p != ALL_FORM_VALUE && $partido && $partido != ALL_URL_STRING) {
  		$p_url .= "$partido";
  	}
  	
  	if ($institucion) {
  		$i_url = "$institucion";
  	}
  	
  	if ($p_url == "" && $i_url == ""){
  		// Todos. Sin filtro
  		$url = "@ranking_${culture}_all";
  	}
  	else if ($p_url != "" && $i_url != ""){
  		// Filtro por partido e institucion
  		$url = "@ranking_${culture}?partido=$p_url&institucion=$i_url";
  	}
  	else if ($i_url == "" ){
  		// Filtro por partido
  		$url = "@ranking_${culture}_partido?partido=$p_url";
  	}
  	else if ($p_url == ""){
  		// Filtro por institucion
  		$url = "@ranking_${culture}?partido=all&institucion=$i_url";
  	}
  	
  	return $url;
  }
  
  public function executeRanking(sfWebRequest $request)
  {
  	$p = $request->getParameter("p");
  	$culture = $request->getParameter("sf_culture");
  	$partido = $request->getParameter("partido");
  	$institucion = $request->getParameter("institucion");
  	if ($p != ''){
	  	$url = $this->generateRankingUrl ($partido, $institucion, $p);
	   	$this->redirect( $url );
  	}
  	
  	$c = new Criteria();
  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID, Criteria::LEFT_JOIN);
  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
  	$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
  	$c->add(PoliticoPeer::VANITY, null, Criteria::ISNOTNULL);
  	$this->partido = ALL_FORM_VALUE;
  	$this->institucion = ALL_FORM_VALUE;
  	
  	if ($partido && $partido != ALL_URL_STRING){
  		$this->partido = $partido; 
  		$c->add(PartidoPeer::ABREVIATURA, $this->partido);
  	}
  	else {
  		$this->partido = ALL_URL_STRING; 
   	}
  	if ($institucion && $institucion != ALL_URL_STRING){
  		$this->institucion = $institucion; 
  		$c->add(InstitucionI18nPeer::VANITY, $this->institucion);
  		
  		$aInstitucionCriteria = new Criteria();
		$aInstitucionCriteria->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
  		$aInstitucionCriteria->add(InstitucionI18nPeer::VANITY, $this->institucion);
  		$aInstitucion = InstitucionPeer::doSelectOne($aInstitucionCriteria);
  	}
  	$pager = new sfPropelPager('Politico', 20);
  	
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
  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMU);
  	}
  	else if ($o == "pd") {
  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	}
  	else if ($o == "na"){
  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	}
  	else if ($o == "nd") {
  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMD);
  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMU);
  	}
  	$this->order = $o;
  	/* Fin Orden */
  	
	$c->setDistinct();
	
	/* Calcula totales. Ver impacto en rendimiento */
    $allPoliticos = PoliticoPeer::doSelect( $c );    
    $this->totalUp = 0;
    $this->totalDown = 0;
    foreach ($allPoliticos as $aPolitico){
	    	$this->totalUp += $aPolitico->getSumu();
    	$this->totalDown += $aPolitico->getSumd();
    }
	/* Fin Calcula totales */
    
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->forward404Unless( $pager->getNbResults() != 0 );
    $this->politicosPager = $pager;
    
  	
  	/* Lista de partidos */ 
    $c = new Criteria();
  	if ($institucion && $institucion != ALL_URL_STRING){
  		$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID);
	  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
	  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
  		$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
	  	$c->setDistinct();
  		$c->add(InstitucionI18nPeer::VANITY, $this->institucion);
  	}
  	$c->addAscendingOrderByColumn(PartidoPeer::ABREVIATURA);
  	$c->add(PartidoPeer::IS_ACTIVE, true);
  	$c->add(PartidoPeer::IS_MAIN, true);
  	$this->partidos = PartidoPeer::doSelect( $c );
  	$this->partidos_arr = array();
  	$this->partidos_arr["0"] = "Todos los partidos";
  	foreach($this->partidos as $aPartido){
  		$this->partidos_arr[$aPartido->getAbreviatura()] = $aPartido->getAbreviatura();
  	}
  	/* Fin lista de partidos */ 
      	
  	/* Lista de instituciones */ 
  	$c = new Criteria();
  	if ($partido && $partido != ALL_URL_STRING){
	  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
	  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
  		$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID);
	  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
  		$c->add(PartidoPeer::ABREVIATURA, $this->partido);
  	}
  	$c->add(InstitucionPeer::DISABLED, 'N');
  	$c->setDistinct();
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
  	
  	$this->pageTitle = sfContext::getInstance()->getI18N()->__('Ranking de políticos', array());
  	$this->pageTitle .= $this->partido=='all'?'':', '.$this->partido;
  	$this->pageTitle .= $this->institucion=='0'?'':", " . $aInstitucion->getNombre();
  	$this->title = $this->pageTitle . ' - Voota';
  	
  	$description = sfContext::getInstance()->getI18N()->__('Ranking de políticos', array());
  	if ($this->politicosPager->getNbResults() > 0){
	  	$list = $this->politicosPager->getResults();
  		if ($this->partido != '0' && $list[0]->getPartido()) {
	  		$description .= ", " . $list[0]->getPartido()->getNombre();
   		}
	  	if ($this->institucion != '0') {
	  		$ci = new Criteria();
  			$ci->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
	  		$ci->add(InstitucionI18nPeer::VANITY, $this->institucion);
	  		$institucion = InstitucionPeer::doSelectOne( $ci );
	  		$description .= ", " . $institucion->getNombre()." (". $institucion->getGeo()->getNombre() .", España)";
   		}
  	}
  	$this->response->addMeta('Description', $description);
  	
  	
    $this->response->setTitle( $this->title );
  }
  
  public function executeShow(sfWebRequest $request)
  {  	  	  	
  	$vanity = $request->getParameter('id');
  	$culture = $this->getUser()->getCulture();
  	
  	
  	$c = new Criteria();
  	$c->add(PoliticoPeer::VANITY, $vanity, Criteria::EQUAL);
  	$politico = PoliticoPeer::doSelectOne( $c );
  	$this->forward404Unless( $politico );
  	
  	$this->partido = $request->getParameter("partido");
  	$this->institucion = $request->getParameter("institucion");
  	$this->rankingUrl = $this->generateRankingUrl ($this->partido, $this->institucion);
  	
  	$this->politico = $politico;
  	$id = $this->politico->getId();
  	
  	$this->forward404Unless($this->politico);
  	
  	// Estabamos vootando antes del login ?
  	$v = $this->getUser()->getAttribute('review_v');
  	if ($v && $v != ''){
  		$e = $this->getUser()->getAttribute('review_e');
  		$this->getUser()->setAttribute('review_v', '');
  		$this->getUser()->setAttribute('review_e', '');
  		
  		if ($e == $id && $this->getUser()->isAuthenticated()) {
  			$this->review_v = $v;
  		}	
  	}
    
  	/*
	$imageFileName = sfConfig::get('sf_upload_dir').'/politicos/'.$this->politico->getImagen();
	if (!file_exists($imageFileName)){
		// Sin imagen: Imagen genérica Voota
		$imageFileName = sfConfig::get('sf_web_dir').'/images/p_unknown.png';
	}
	*/
	
  	if ($this->politico->getImagen() != ''){
  		$imageFileName = $this->politico->getImagen();
  	}
  	else {
  		$imageFileName = "p_unknown.png";
   	}
	
	$this->image = "bw_$imageFileName";
	
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
	
	
  	$exclude = array();
	$this->lastPositives = SfReviewManager::getLastReviewsByEntityAndValue($request, 1, $id, 1, 3);
	$this->lastNegatives = SfReviewManager::getLastReviewsByEntityAndValue($request, 1, $id, -1, 3);
    foreach ($this->lastPositives->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
	$this->positives = SfReviewManager::getReviewsByEntityAndValue($request, 1, $id, 1, $resU-3, $exclude);
    foreach ($this->lastNegatives->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue($request, 1, $id, -1, $resD-3, $exclude);
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
  	$this->title = sfContext::getInstance()->getI18N()->__('%1%, opiniones a favor y en contra en Voota'
  					, array(
  						'%1%' => $this->politico->getNombre() . ' '. $this->politico->getApellidos()
  					)
  	);
  	
  	$description = sfContext::getInstance()->getI18N()->__('Página de', array());
  	$description .= ' ' . $this->politico->getNombre() . ' '. $this->politico->getApellidos();
	if (count($this->politico->getPoliticoInstitucions()) > 0) {
  		$description .= " ("; //instituciones
		foreach ($this->politico->getPoliticoInstitucions() as $idx => $politicoInstitucion){
			if ($idx > 0) {
				$description .= ', ';	
			}
			$description .= $politicoInstitucion->getInstitucion()->getNombre();			
		}
	  	$description .= ")";
	}
  	$description .= ", ".$this->politico->getPartido().", "; //partido
  	$description .= sfContext::getInstance()->getI18N()->__('%1% votos a favor y %2% votos en contra.', array('%1%' => $positiveCount, '%2%' => $negativeCount));
    $this->response->addMeta('Description', $description);
  	
    $this->response->setTitle( $this->title );
    
    // Enlaces
    $c = new Criteria();
	$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
	$c->add( $rCriterion );
	$c->add(EnlacePeer::POLITICO_ID, $id);
    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    
  }

}

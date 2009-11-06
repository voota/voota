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

class politicoActions extends sfVoActions
{
	
  public function executeIndex(sfWebRequest $request)
  {
    $this->politico_list = PoliticoPeer::doSelect(new Criteria());
  }
  
  public function executeRanking(sfWebRequest $request)
  {
  	$p = $request->getParameter("p");
  	$culture = $request->getParameter("sf_culture");
  	$partido = $request->getParameter("partido");
  	$institucion = $request->getParameter("institucion");
  	if ($p != ''){
	  	$p_url = "";
	  	$i_url = "";
	  	
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
	  		  	
	   	$this->redirect( $url );
  	}
  	
  	$c = new Criteria();
  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID, Criteria::LEFT_JOIN);
  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
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
  		$c->add(InstitucionPeer::NOMBRE, $this->institucion);
  	}
  	$pager = new sfPropelPager('Politico', 10);
  	
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
  	}
  	else if ($o == "na"){
  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	}
  	else if ($o == "nd") {
  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMD);
  	}
  	$this->order = $o;
  	/* Fin Orden */
  	
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->politicosPager = $pager;
    
    $this->totalUp = 0;
    $this->totalDown = 0;
    foreach ($pager->getResults() as $aPolitico){
    	$this->totalUp += $aPolitico->getSumu();
    	$this->totalDown += $aPolitico->getSumd();
    }
  	
  	$this->partidos = PartidoPeer::doSelect(new Criteria());
  	$this->partidos_arr = array();
  	$this->partidos_arr["0"] = "Todos los partidos";
  	foreach($this->partidos as $partido){
  		$this->partidos_arr[$partido->getAbreviatura()] = $partido->getAbreviatura();
  	}
    
  	$c = new Criteria();
  	$c->add(InstitucionPeer::DISABLED, 'N');
  	$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
  	$this->instituciones = InstitucionPeer::doSelect($c);
  	
  	
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
  }
  
  public function executeShow(sfWebRequest $request)
  {  	  	
  	$id = $request->getParameter('id');
  	$this->politico = PoliticoPeer::retrieveByPk($request->getParameter('id'));
  	
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
	
	$this->positives = SfReviewManager::getReviewsByEntityAndValue($request, 1, $id, 1);
	$positiveCount =  SfReviewManager::getTotalReviewsByEntityAndValue(1, $id, 1);
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue($request, 1, $id, -1);
	$negativeCount =  SfReviewManager::getTotalReviewsByEntityAndValue(1, $id, -1);
	
	$totalCount = $positiveCount + $negativeCount;
	if ($totalCount > 0) {
		$this->positivePerc = intval( $positiveCount * 100 / ($positiveCount + $negativeCount) );
		$this->negativePerc = 100 - $this->positivePerc;
	}  
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PoliticoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PoliticoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($politico = PoliticoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object politico does not exist (%s).', $request->getParameter('id')));
    $this->form = new PoliticoForm($politico);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($politico = PoliticoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object politico does not exist (%s).', $request->getParameter('id')));
    $this->form = new PoliticoForm($politico);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($politico = PoliticoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object politico does not exist (%s).', $request->getParameter('id')));
    $politico->delete();

    $this->redirect('politico/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $politico = $form->save();

      $this->redirect('politico/edit?id='.$politico->getId());
    }
  }
}

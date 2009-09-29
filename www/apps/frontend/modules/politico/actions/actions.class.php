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
  	$i = $request->getParameter("i");
  	$culture = $request->getParameter("sf_culture");
  	$partido = $request->getParameter("partido");
  	$institucion = $request->getParameter("institucion");
  	if ($p != '' || $i != ''){
	  	$url = "/$culture/politicos";
	  	$p_url = "";
	  	$i_url = "";
	  	if ($p != '' && $p != ALL_FORM_VALUE){
	  		$p_url .= "/$p";
	  	}
	  	else if ($p != ALL_FORM_VALUE && $partido && $partido != ALL_URL_STRING) {
	  		$p_url .= "/". $partido;
	  	}
	  	if ($i != ''){
	  		if ($i != ALL_FORM_VALUE){
	  			$i_url = "/$i";
	  		}
	  	}
	  	else if ($i != ALL_FORM_VALUE && $institucion) {
  			$i_url = "/". $institucion;
	  	}
	  	
	  	if ($p_url != "" ){
	  		$url .= $p_url;
	  	}
	  	else if ($i_url != ""){
	  		$url .= "/".ALL_URL_STRING;
	  	}
	  	if ($i_url != ""){
	  		$url .= $i_url;
	  	}
	  		  	
	   	$this->redirect( $url );
  	}
  	
  	$c = new Criteria();
  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID);
  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
  	$this->partido = ALL_FORM_VALUE;
  	$this->institucion = ALL_FORM_VALUE;
  	
  	if ($partido && $partido != ALL_URL_STRING){
  		$this->partido = $partido; 
  		$c->add(PartidoPeer::ABREVIATURA, $this->partido);
  	}
  	if ($institucion && $institucion != ALL_URL_STRING){
  		$this->institucion = $institucion; 
  		$c->add(InstitucionPeer::NOMBRE, $this->institucion);
  	}
  	$pager = new sfPropelPager('Politico', 10);
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    $this->politicosPager = $pager;
  	
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
    
	$imageFileName = sfConfig::get('sf_upload_dir').'/politicos/'.$this->politico->getImagen();
	if (!file_exists($imageFileName)){
		// Sin imagen: Imagen genérica Voota
		$imageFileName = sfConfig::get('sf_web_dir').'/images/p_unknown.png';
	}
	$img = new sfImage( $imageFileName );
	$img->voota( $imageFileName );
	
	$this->image = "bw_" . $this->politico->getImagen();
	
	$this->positives = SfReviewManager::getReviewsByEntityAndValue(1, $id, 1);
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue(1, $id, -1);
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

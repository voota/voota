<?php

/**
 * eleccion actions.
 *
 * @package    sf_sandbox
 * @subpackage eleccion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
  	$vanity = $request->getParameter('vanity');
  	$convocatoria = $request->getParameter('convocatoria');
  	$this->geoName = $request->getParameter('geo');
  	$partido = $request->getParameter('partido');
  	$order = $request->getParameter("o", "");	
	
  	$c = new Criteria();
  	$c->addJoin(ListaPeer::CIRCUNSCRIPCION_ID, CircunscripcionPeer::ID);
  	$c->addJoin(CircunscripcionPeer::GEO_ID, GeoPeer::ID);
  	$c->addJoin(ListaPeer::PARTIDO_ID, PartidoPeer::ID);
  	$c->addJoin(ListaPeer::CONVOCATORIA_ID, ConvocatoriaPeer::ID);
  	$c->addJoin(ConvocatoriaPeer::ELECCION_ID, EleccionPeer::ID);
  	$c->add(ConvocatoriaPeer::NOMBRE, $convocatoria);
  	$c->add(GeoPeer::NOMBRE, $this->geoName);
  	$c->add(PartidoPeer::ABREVIATURA, $partido);
  	$c->add(EleccionPeer::VANITY, $vanity);
  	
  	$this->lista = ListaPeer::doSelectOne( $c );
  	
  	$this->forward404Unless( $this->lista );
  	  	
    // Geos
  	$c = new Criteria();
  	$c->addJoin(ListaPeer::CIRCUNSCRIPCION_ID, CircunscripcionPeer::ID);
  	$c->addJoin(CircunscripcionPeer::GEO_ID, GeoPeer::ID);
  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->lista->getConvocatoria()->getId());
  	$c->add(ListaPeer::PARTIDO_ID, $this->lista->getPartido()->getId());
  	$c->addAscendingOrderByColumn(GeoPeer::NOMBRE);
  	$c->setDistinct();
  	$this->geos = GeoPeer::doSelect( $c );
  	
  	$instituciones = $this->lista->getConvocatoria()->getEleccion()->getEleccionInstitucions();
  	$this->institucionName = $instituciones[0]->getInstitucion();
  	
  	// Lista Voota
  	$c = new Criteria();
  	$c->add(ConvocatoriaPeer::NOMBRE, $convocatoria);
  	$this->convocatoria = ConvocatoriaPeer::doSelectOne( $c );

	$this->order = $order?$order:'pd';		  	
  		/*
  	if ($this->convocatoria->getClosedAt()){
	  	$c = new Criteria();
	  	$c->addJoin(ListaCallePeer::POLITICO_ID, PoliticoPeer::ID);
	  	$c->addJoin(PoliticoListaPeer::POLITICO_ID, PoliticoPeer::ID);
	  	$c->add(PoliticoListaPeer::LISTA_ID, $this->lista->getId());
	  	
	  	if ($this->order == "pa"){
	  		$c->addAscendingOrderByColumn(ListaCallePeer::SUMU);
	  	}
	  	else if ($this->order == "pd") {
	  		$c->addDescendingOrderByColumn(ListaCallePeer::SUMU);
	  		$c->addAscendingOrderByColumn(ListaCallePeer::SUMD);
	  	}
	  	else if ($this->order == "na"){
	  		$c->addAscendingOrderByColumn(ListaCallePeer::SUMD);
	  	}
	  	else if ($this->order == "nd") {
	  		$c->addDescendingOrderByColumn(ListaCallePeer::SUMD);
	  		$c->addAscendingOrderByColumn(ListaCallePeer::SUMU);
	  	}
	  	$c->setDistinct();
	  	$this->politicosListaVoota = PoliticoPeer::doSelect( $c );
  	}
  	else {
	  	$c = new Criteria();
	  	$c->addJoin(PoliticoListaPeer::POLITICO_ID, PoliticoPeer::ID);
	  	$c->add(PoliticoListaPeer::LISTA_ID, $this->lista->getId());
	  	if ($this->order == "pa"){
	  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMU);
	  	}
	  	else if ($this->order == "pd") {
	  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
	  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
	  	}
	  	else if ($this->order == "na"){
	  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
	  	}
	  	else if ($this->order == "nd") {
	  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMD);
	  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMU);
	  	}
	  	$this->politicosListaVoota = PoliticoPeer::doSelect( $c );
	  	
  	}
	  	*/
	$listaElectoral = new ListaElectoral($this->lista->getConvocatoriaId(), $this->lista->getPartidoId(), $this->lista->getCircunscripcion()->getGeo()->getNombre(), $this->order);
	$this->politicosListaVoota = $listaElectoral->getPoliticos();
  	
  	// Lista oficial
  	$c = new Criteria();
  	$c->addJoin(PoliticoListaPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->add(PoliticoListaPeer::LISTA_ID, $this->lista->getId());
  	$c->add(PoliticoListaPeer::ORDEN, null, Criteria::ISNOTNULL);
  	$c->add(PoliticoListaPeer::ORDEN, 0, Criteria::GREATER_THAN);
  	$c->addAscendingOrderByColumn(PoliticoListaPeer::ORDEN);
  	$this->politicosListaOficial = PoliticoPeer::doSelect( $c );
	
  	// Metas
  	$this->title = sfContext::getInstance()->getI18N()->__("Lista electoral %1% %2% %3%, %4%", array(
  		'%1%' => $this->lista->getPartido(), 
  		'%2%' => $this->lista->getConvocatoria()->getEleccion()->getNombre(), 
  		'%3%' => $this->lista->getConvocatoria()->getNombre(), 
  		'%4%' => $this->lista->getCircunscripcion()->getGeo()
  	));  	
  	$this->response->setTitle( $this->title ); 
  	
  	$description = sfContext::getInstance()->getI18N()->__("Lista oficial del partido vs Lo que dice la calle: %1%, circunscripcón de %2%, %3% %4%", array(
  		'%1%' => $this->lista->getPartido()->getNombre(), 
  		'%2%' => $this->lista->getCircunscripcion()->getGeo(),
  		'%3%' => $this->lista->getConvocatoria()->getEleccion()->getNombre(), 
  		'%4%' => $this->lista->getConvocatoria()->getNombre(), 
  	));  	
  		
    $this->response->addMeta('Description', $description); 
  }
  
  public function executeList(sfWebRequest $request)
  {
  	$culture = $this->getUser()->getCulture("es");
  	$page = $request->getParameter("page", "");
  	$this->autonomicas = $request->getParameter("a", false);
  	$this->municipales = $request->getParameter("m", false);
  	$this->partido = $request->getParameter("partido", false);
  	if ($this->partido){
	  	$c = new Criteria();
	  	$c->add(PartidoPeer::ABREVIATURA, $this->partido);
	  	$partido = PartidoPeer::doSelectOne($c);
  	}
  	$this->route = "lista/list";
  	
  	
  	#$this->pager = EntityManager::getConvocatorias($culture, $page, 100, $this->autonomicas, $this->municipales, &$totalUp, &$totalDown);
  	$this->pager = EntityManager::getListas($culture, $page, 100, $this->autonomicas, $this->municipales, $this->partido, &$totalUp, &$totalDown);
  	
  	$o = false;
  	if($this->autonomicas)
  		$o = EntityManager::getListas($culture, $page, 100, false, 1, $this->partido, &$totalUp, &$totalDown);
  	if($this->municipales)
  		$o = EntityManager::getListas($culture, $page, 100, 1, false, $this->partido, &$totalUp, &$totalDown);

  	$this->hide = ($o && $o->getNbResults() == 0);
  	
  	// Metas
  	$this->title = sfContext::getInstance()->getI18N()->__("Listas%partido% a las elecciones%tipo%%pag%", array(
  		'%partido%' => $this->partido?" de $this->partido":'',
  		'%tipo%' => $this->municipales?" municipales":($this->autonomicas?" autonómicas":''),
  		'%pag%' => ($page && $page > 1)?", pág. $page":'',  	
   	));	
  	$this->response->setTitle( $this->title );  	
  	
  	$description = sfContext::getInstance()->getI18N()->__("Candidaturas y listas%partido% a las elecciones%tipo%%pag%", array(
  		'%partido%' => $this->partido?" de ".$partido->getNombre()." (".$this->partido.")":'',
  		'%tipo%' => $this->municipales?" municipales":($this->autonomicas?" autonómicas":''),
  		'%pag%' => ($page && $page > 1)?", pág. $page":'',  	
   	));	 	
    $this->response->addMeta('Description', $description);
  }
}

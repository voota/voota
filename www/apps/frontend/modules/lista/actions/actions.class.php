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
  	$c->addJoin(ListaPeer::GEO_ID, GeoPeer::ID);
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
  	$c->addJoin(ListaPeer::GEO_ID, GeoPeer::ID);
  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->lista->getConvocatoria()->getId());
  	$c->add(ListaPeer::PARTIDO_ID, $this->lista->getPartido()->getId());
  	$c->addAscendingOrderByColumn(GeoPeer::NOMBRE);
  	$c->setDistinct();
  	$this->geos = GeoPeer::doSelect( $c );
  	
  	$instituciones = $this->lista->getConvocatoria()->getEleccion()->getEleccionInstitucions();
  	$this->institucionName = $instituciones[0]->getInstitucion();
  	
  	// Lista Voota
  	$c = new Criteria();
  	$c->addJoin(PoliticoListaPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->add(PoliticoListaPeer::LISTA_ID, $this->lista->getId());
	/* Orden de resultados
  	 * pa: positivos ascendente
  	 * pd: positivos descendente
  	 * na: negativos ascendente
  	 * nd: negativos descendente
  	 */	
	$this->order = $order?$order:'pd';		  	
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
  	
  	// Lista oficial
  	$c = new Criteria();
  	$c->addJoin(PoliticoListaPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->add(PoliticoListaPeer::LISTA_ID, $this->lista->getId());
  	$c->add(PoliticoListaPeer::ORDEN, null, Criteria::ISNOTNULL);
  	$c->addAscendingOrderByColumn(PoliticoListaPeer::ORDEN);
  	$this->politicosListaOficial = PoliticoPeer::doSelect( $c );
	
  	// Metas
  	$this->title = sfContext::getInstance()->getI18N()->__("Lista electoral %1% %2% %3%, %4%", array(
  		'%1%' => $this->lista->getPartido(), 
  		'%2%' => $this->lista->getConvocatoria()->getEleccion()->getNombre(), 
  		'%3%' => $this->lista->getConvocatoria()->getNombre(), 
  		'%4%' => $this->lista->getGeo()
  	));  	
  	$this->response->setTitle( $this->title ); 
  	
  	$description = sfContext::getInstance()->getI18N()->__("Lista oficial del partido vs Lo que dice la calle: %1%, circunscripcón de %2%, %3% %4%", array(
  		'%1%' => $this->lista->getPartido()->getNombre(), 
  		'%2%' => $this->lista->getGeo(),
  		'%3%' => $this->lista->getConvocatoria()->getEleccion()->getNombre(), 
  		'%4%' => $this->lista->getConvocatoria()->getNombre(), 
  	));  	
  		
    $this->response->addMeta('Description', $description); 
  }
}

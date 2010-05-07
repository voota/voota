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
  }
}

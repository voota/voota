<?php

/**
 * eleccion actions.
 *
 * @package    sf_sandbox
 * @subpackage eleccion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eleccionActions extends sfActions
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
  	$this->geoName = $request->getParameter('geo', false);
  	
  	$c = new Criteria();
  	$c->addJoin(ConvocatoriaPeer::ELECCION_ID, EleccionPeer::ID);
  	$c->add(ConvocatoriaPeer::NOMBRE, $convocatoria);
  	$c->add(EleccionPeer::VANITY, $vanity);
  	
  	$this->convocatoria = ConvocatoriaPeer::doSelectOne($c);
  	$this->forward404Unless( $this->convocatoria );
  	
  	$c = new Criteria();
  	$c->addJoin(ListaPeer::PARTIDO_ID, PartidoPeer::ID);
  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->convocatoria->getId());
  	$c->setDistinct();
  	$this->partidos = PartidoPeer::doSelect( $c );
  	
    // Enlaces
    $c = new Criteria();
	$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
	$c->add( $rCriterion );
	$c->add(EnlacePeer::CONVOCATORIA_ID, $this->convocatoria->getId());
    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    
    // Geos
  	$c = new Criteria();
  	$c->addJoin(ListaPeer::GEO_ID, GeoPeer::ID);
  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->convocatoria->getId());
  	$c->setDistinct();
  	$this->geos = GeoPeer::doSelect( $c );
  	
  	$instituciones = $this->convocatoria->getEleccion()->getEleccionInstitucions();
  	$this->institucionName = $instituciones[0]->getInstitucion();
  }
}

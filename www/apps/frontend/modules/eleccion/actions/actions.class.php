<?php

/**
 * eleccion actions.
 *
 * @package    Voota
 * @subpackage eleccion
 * @author     Sergio Viteri
 */

require_once(sfConfig::get('sf_lib_dir').'/vendor/symfony/lib/helper/DateHelper.php');

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
  	
    // Enlaces
    $c = new Criteria();
	$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
	$c->add( $rCriterion );
	$c->add(EnlacePeer::CONVOCATORIA_ID, $this->convocatoria->getId());
    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    
    $ret = $this->convocatoria->getResults($this->geoName);
    $this->partidos = $ret['partidos'];
    $this->totalEscanyos = $ret['totalEscanyos'];
    $this->minSumu = $ret['minSumu'];
    $this->minSumd = $ret['minSumd'];
    $this->lastDate = $ret['lastDate'];
    $this->apellidos = $ret['apellidos'];
    $this->institucionName = $ret['institucionName'];
    $this->circus = $ret['circus'];
    
  	
  	// Metas
  	$this->title = ($this->geoName?$this->geoName.': ':'') . $this->convocatoria->getEleccion()->getNombre() ." ". $this->convocatoria->getNombre();  	
  	$this->response->setTitle( $this->title );  	
  	$description = sfContext::getInstance()->getI18N()->__("%1%.%2%: listas%3%, partidos, candidatos, previsión de escaños, votos de los usuarios, ...", array(
  		'%1%' => $this->convocatoria->getEleccion()->getNombre(),
  		'%2%' => sfContext::getInstance()->getI18N()->__("%dia% de %mes%", array('%dia%' => format_date($this->convocatoria->getFecha(), ' d'), '%mes%' => format_date($this->convocatoria->getFecha(), 'MMMM'))),
  		'%3%' => $this->geoName?' '.$this->geoName:''
  	));  	
    $this->response->addMeta('Description', $description);
  } 
  
  public function executeList(sfWebRequest $request)
  {
  	$culture = $this->getUser()->getCulture("es");
  	$page = $request->getParameter("page", "");
  	$this->autonomicas = $request->getParameter("a", false);
  	$this->municipales = $request->getParameter("m", false);
  	$this->route = "eleccion/list";
  	
  	
  	$this->pager = EntityManager::getConvocatorias($culture, $page, EntityManager::PAGE_SIZE, &$totalUp, &$totalDown);
  	
  	// Metas
  	$this->title = sfContext::getInstance()->getI18N()->__('Elecciones en España');	
  	$this->response->setTitle( $this->title );  	
  	$description = sfContext::getInstance()->getI18N()->__("Acceso a las candidaturas y listas de las próximas elecciones municipales, autonómicas, generales o europeas en España");  	
    $this->response->addMeta('Description', $description);
  }
}

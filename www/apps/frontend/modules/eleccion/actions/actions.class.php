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
  	
  	// Minimo de votos necesario para obtener escaño
  	$listas = $this->convocatoria->getListas();
  	if($this->geoName){
  		$numEscanyos = count($listas[0]->getPoliticoListas());
  	}
  	else {
  		$numEscanyos = 0;
  		$geoCounted = array();
  		foreach($listas as $lista){
  			if(!in_array($lista->getGeo()->getId(), $geoCounted)){
  				$geoCounted[] = $lista->getGeo()->getId();
  				$numEscanyos += count($lista->getPoliticoListas());
  			}
  		}
  	}
  	$c = new Criteria();
  	$c->addJoin(ListaPeer::ID, PoliticoListaPeer::LISTA_ID);
  	$c->addJoin(PoliticoPeer::ID, PoliticoListaPeer::POLITICO_ID);
  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->convocatoria->getId());
  	if($this->geoName){
  		$c->addJoin(ListaPeer::GEO_ID, GeoPeer::ID);
  		$c->add(GeoPeer::NOMBRE, $this->geoName);
  	}
  	$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);  	
  	$politicos = PoliticoPeer::doSelect( $c );
  	$idx = 0;
  	$this->minSumu = 0;
  	$this->minSumd = 0;
  	foreach ($politicos as $politico){
  		$idx++;
  		if ($idx == ($numEscanyos + 1)){
  			$this->minSumu = $politico->getSumu();
  			$this->minSumd = $politico->getSumd();
  		}
  	}
  	
  	// Ordenar por escaños
  	$idx = 0;
  	foreach($this->partidos as $partido){
  		$listaElectoral = new ListaElectoral($this->convocatoria->getId(), $partido->getId(), $this->geoName);
  		for ($j=0;$j<$idx;$j++){
  			$listaElectoral2 = new ListaElectoral($this->convocatoria->getId(), $this->partidos[$j]->getId(), $this->geoName);
  			if ($listaElectoral2->getEscanyos($this->minSumu, $this->minSumd) < $listaElectoral->getEscanyos($this->minSumu, $this->minSumd)){
  				$partidoTmp = clone $this->partidos[$idx];
  				$this->partidos[$idx] = $this->partidos[$j];
  				$this->partidos[$j] = $partidoTmp;
  			}
  		}
  		$idx ++;
  	}
  	
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
}

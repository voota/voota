<?php

/**
 * eleccion actions.
 *
 * @package    Voota
 * @subpackage ListaElectoral
 * @author     Sergio Viteri
 */

class ListaElectoral
{
  public function __construct($convocatoria_id, $partido_id, $geoName)
  {
 	$c = new Criteria();
	$c->addJoin(PoliticoPeer::ID, PoliticoListaPeer::POLITICO_ID);
	$c->addJoin(PoliticoListaPeer::LISTA_ID, ListaPeer::ID);
	$c->add(ListaPeer::CONVOCATORIA_ID, $convocatoria_id);
	$c->add(ListaPeer::PARTIDO_ID, $partido_id);
	if ($geoName){
		$c->addJoin(GeoPeer::ID, ListaPeer::GEO_ID);
		$c->add(GeoPeer::NOMBRE, $geoName);
	}
  	$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
	$c->setDistinct();
	$this->politicos = PoliticoPeer::doSelect( $c );
	
	$this->numEscanyos = false;				
  }

  public function getPoliticos() {
  	return $this->politicos;
  }
  
  public function getEscanyos($minSumu, $minSumd) {
  	if (!$this->numEscanyos) {
		$this->numEscanyos = 0;
		foreach($this->politicos as $politico){
			if ($politico->getSumu() > $minSumu || ($politico->getSumu() == $minSumu && $politico->getSumd() < $minSumd)){
				$this->numEscanyos++;
			}
		}
  	}
  		
  	return $this->numEscanyos;
  }
}	  
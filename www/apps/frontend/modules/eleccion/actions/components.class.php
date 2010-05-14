<?php

class eleccionComponents extends sfComponents
{
	public function executePartidoLista(){
		$c = new Criteria();
		$c->addJoin(PoliticoPeer::ID, PoliticoListaPeer::POLITICO_ID);
		$c->addJoin(PoliticoListaPeer::LISTA_ID, ListaPeer::ID);
		$c->add(ListaPeer::CONVOCATORIA_ID, $this->convocatoria->getId());
		$c->add(ListaPeer::PARTIDO_ID, $this->partido->getId());
		if ($this->geoName){
			$c->addJoin(GeoPeer::ID, ListaPeer::GEO_ID);
			$c->add(GeoPeer::NOMBRE, $this->geoName);
		}
		$c->setDistinct();
		$this->politicos = PoliticoPeer::doSelect( $c );
		
		$this->numEscanyos = 0;
		foreach($this->politicos as $politico){
			if ($politico->getSumu() > $this->minSumu || ($politico->getSumu() == $this->minSumu && $politico->getSumd() < $this->minSumd)){
				$this->numEscanyos++;
			}
		}
	}
}

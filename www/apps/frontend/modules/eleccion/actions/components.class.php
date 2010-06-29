<?php

class eleccionComponents extends sfComponents
{
	public function executePartidoLista(){
		$listaElectoral = new ListaElectoral($this->convocatoria->getId(), $this->partido->getId(), $this->geoName);
		$this->politicos = $listaElectoral->getPoliticos();				
		$this->numEscanyos = $listaElectoral->getEscanyos($this->minSumu, $this->minSumd);
	}
}

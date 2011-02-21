<?php

require 'lib/model/om/BaseConvocatoria.php';


/**
 * Skeleton subclass for representing a row from the 'convocatoria' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May  4 14:41:20 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Convocatoria extends BaseConvocatoria {

  public function __toString()
  {
    return $this->getEleccion(). " " .$this->getNombre();    
  }
  
  public function closeGeo($res, $circu = false){
  	foreach($res['partidos'] as $partido){
		$listaElectoral = new ListaElectoral($this->getId(), $partido->getId(), $circu?$circu->getGeo()->getNombre():false);
		$politicos = $listaElectoral->getPoliticos();
		foreach($politicos as $politico){
			$listaCalle = new ListaCalle();
			$listaCalle->setConvocatoria($this);
			$listaCalle->setPartido($partido);
			if ($circu)
				$listaCalle->setCircunscripcion($circu);
			$listaCalle->setPoliticoId($politico->getId());
			$listaCalle->setSumu($politico->getSumu());
			$listaCalle->setSumd($politico->getSumd());
			$listaCalle->save();
		}				
  	}
  }

  public function close(){
  	$res = $this->getResults();
  	foreach ($res['circus'] as $circu){
  		$this->closeGeo( $res, $circu );
  	}
  	$this->closeGeo( $res );
  }
  
  public function reopen(){
  	$c = new Criteria();
  	$c->add(ListaCallePeer::CONVOCATORIA_ID, $this->getId());
  	ListaCallePeer::doDelete($c);
  }
  
  public function getResults($geoName = false, $sorted = true){ 	
   	$key = "Convocatoria_".$this->getId()."-$geoName-$sorted";
   
    $cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
	
	if ($cache) {
		$key=md5($key);
		$data = unserialize($cache->get($key));
	}
	else {
		$data = false;
	}
	
	if (!$data){
	  	$res = array();
	  	  	
	  	$c = new Criteria();
	  	$c->addJoin(ListaPeer::PARTIDO_ID, PartidoPeer::ID);
	  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->getId());
	  	$c->setDistinct();
	  	$res['partidos'] = PartidoPeer::doSelect( $c );
	  	
	    // Circus
	  	$c = new Criteria();
	  	$c->addJoin(ListaPeer::CIRCUNSCRIPCION_ID, CircunscripcionPeer::ID);
	  	$c->addJoin(CircunscripcionPeer::GEO_ID, GeoPeer::ID);
	  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->getId());
	  	$c->addAscendingOrderByColumn(GeoPeer::NOMBRE);
	  	$c->setDistinct();
	  	//$this->geos = GeoPeer::doSelect( $c );
	  	$res['circus'] = CircunscripcionPeer::doSelect( $c );
	  	
	  	$instituciones = $this->getEleccion()->getEleccionInstitucions();
	  	//$this->institucionName = $instituciones[0]->getInstitucion();
	  	$res['institucionName'] = $instituciones[0]->getInstitucion();
	  	
	  	// Minimo de votos necesario para obtener escaño
	  	$listas = $this->getListas();
	  	if($geoName){
		  	$c = new Criteria();
		  	$c->addJoin(ListaPeer::CIRCUNSCRIPCION_ID, CircunscripcionPeer::ID);
		  	$c->addJoin(CircunscripcionPeer::GEO_ID, GeoPeer::ID);
		  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->getId());
		  	$c->add(GeoPeer::NOMBRE, $geoName);
		  	//$this->geos = GeoPeer::doSelect( $c );
		  	$circu = CircunscripcionPeer::doSelectOne( $c );
	  		$numEscanyos = $circu->getEscanyos();
	  	}
	  	else {
	  		$numEscanyos = 0;
	  		$circuCounted = array();
	  		foreach($listas as $lista){
	  			if(!in_array($lista->getCircunscripcion()->getId(), $circuCounted)){
	  				$circuCounted[] = $lista->getCircunscripcion()->getId();
	  				$numEscanyos += $lista->getCircunscripcion()->getEscanyos();
	  			}
	  		}
	  	}
	  	
	  	$listaElectoral = ListaElectoral::getInstance($this->getId(), false, $geoName);
	  	$politicos = $listaElectoral->getPoliticos();
	  	
	  	$idx = 0;
	  	//$this->minSumu = 0;
	  	$res['minSumu'] = 0;
	  	//$this->minSumd = 0;
	  	$res['minSumd'] = 0;
	  	$res['lastDate'] = null;
	  	$res['apellidos'] = '';
	  	$res['nombre'] = '';
	  	foreach ($politicos as $politico){
	  		$idx++;
	  		if ($idx == ($numEscanyos + 1)){
	  			$res['minSumu'] = $politico->getSumu();
	  			$res['minSumd'] = $politico->getSumd();
			  	$res['lastDate'] = $politico->getLastDate();
			  	$res['apellidos'] = $politico->getApellidos();
			  	$res['nombre'] = $politico->getNombre();
	  		}
	  	}
	   
	  	// Ordenar por escaños
	  	if ($sorted){
		  	$idx = 0;
		  	$res['totalEscanyos'] = 0;
		  	foreach($res['partidos'] as $partido){
		  		$listaElectoral = new ListaElectoral($this->getId(), $partido->getId(), $geoName);
		  		$escanyos = $listaElectoral->getEscanyos($res['minSumu'], $res['minSumd'], $res['lastDate'], $res['apellidos']);
		  		$res['totalEscanyos'] += $escanyos;
		  		for ($j=0;$j<$idx;$j++){
		  			$listaElectoral2 = new ListaElectoral($this->getId(), $res['partidos'][$j]->getId(), $geoName);
		  			if ($listaElectoral2->getEscanyos($res['minSumu'], $res['minSumd'], $res['lastDate'], $res['apellidos']) < $escanyos){
		  				$partidoTmp = clone $res['partidos'][$idx];
		  				$res['partidos'][$idx] = $res['partidos'][$j];
		  				$res['partidos'][$j] = $partidoTmp;
		  			}
		  		}
		  		$idx ++;
		  	}
	  	}
	  	$data = $res;
	
		if ($cache) {
			$n = rand(0, 100);
			$cache->set($key, serialize($data), 3600*$n/100);
		}
	}
  	
  	return $data;
  }
} // Convocatoria

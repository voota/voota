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
   public static function getInstance($convocatoria_id, $partido_id, $geoName, $order = "pd") 
   {   	   	
   	$key = "ListaElectoral_$convocatoria_id-$partido_id-$geoName-$order";
   
    $cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
	
	if ($cache) {
		$key=md5($key);
		$data = unserialize($cache->get($key));
	}
	else {
		$data = false;
	}
	if (!$data){
		$data = new self($convocatoria_id, $partido_id, $geoName, $order);
	
		if ($cache) {
			$cache->set($key, serialize($data), 3600);
		}
	}
	
	return $data;	  
   } 
   
  public function __construct($convocatoria_id, $partido_id, $geoName, $order = "pd")
  {
  	$this->geoName = $geoName;
  	$this->convocatoriaId = $convocatoria_id;
  	$this->partidoId = $partido_id;
  	$this->convocatoria = ConvocatoriaPeer::retrieveByPK($convocatoria_id);

  	if ($this->convocatoria->getClosedAt()){
		$query = "SELECT DISTINCT p.id, p.vanity, p.nombre, p.apellidos, p.imagen, l.sumu, l.sumd, r.last_date lastDate, p.sf_guard_user_id
			FROM politico p
			LEFT JOIN sf_guard_user u ON u.id = p.sf_guard_user_id
			INNER JOIN lista_calle l ON l.politico_id = p.id ";		
		if ($geoName){
			$query .= "INNER JOIN circunscripcion c ON c.id = l.circunscripcion_id ";
			$query .= "INNER JOIN geo g ON g.id = c.geo_id ";
		}
		$query .= "LEFT JOIN (SELECT entity_id, MAX(IFNULL(r.modified_at, r.created_at)) last_date FROM sf_review r WHERE r.value = 1 AND r.sf_review_type_id = 1 GROUP BY entity_id, sf_review_type_id) r ON (r.entity_id = p.id) ";
			
		$query .= "WHERE l.convocatoria_id = ? ";
		if ($partido_id){
			$query .= "AND l.partido_id = ? ";
		}
		if ($geoName){
			$query .= "AND g.nombre = ? ";
		}			
		
		switch ( $order ){
			case 'pa':
				$query .= "ORDER BY l.sumu ASC, l.sumd DESC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
			case 'pd':
				$query .= "ORDER BY l.sumu DESC, l.sumd ASC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
			case 'na':
				$query .= "ORDER BY l.sumd ASC, l.sumu DESC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
			case 'nd':
				$query .= "ORDER BY l.sumd DESC, l.sumu ASC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
		}
  				
		$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$idx = 1;
		$statement->bindValue($idx++, $convocatoria_id);
		if ($partido_id){
			$statement->bindValue($idx++, $partido_id);
		}
		if ($geoName){
			$statement->bindValue($idx++, $geoName);
		}			
		$statement->execute();
		
		$this->politicos = $statement->fetchAll(PDO::FETCH_CLASS, 'Candidato');
  	}
  	else {
		$query = "SELECT DISTINCT p.*, r.last_date lastDate
			FROM politico p
			INNER JOIN politico_lista pl ON pl.politico_id = p.id
			INNER JOIN lista l ON l.id = pl.lista_id ";		
		if ($geoName){
			$query .= "INNER JOIN circunscripcion c ON c.id = l.circunscripcion_id ";
			$query .= "INNER JOIN geo g ON g.id = c.geo_id ";
		}
		$query .= "LEFT JOIN (SELECT entity_id, MAX(IFNULL(r.modified_at, r.created_at)) last_date FROM sf_review r WHERE r.value = 1 AND r.sf_review_type_id = 1 GROUP BY entity_id, sf_review_type_id) r ON (r.entity_id = p.id) ";
			
		$query .= "WHERE l.convocatoria_id = ? ";
		if ($partido_id){
			$query .= "AND l.partido_id = ? ";
		}
		if ($geoName){
			$query .= "AND g.nombre = ? ";
		}			
		
		switch ( $order ){
			case 'pa':
				$query .= "ORDER BY p.sumu ASC, p.sumd DESC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
			case 'pd':
				$query .= "ORDER BY p.sumu DESC, p.sumd ASC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
			case 'na':
				$query .= "ORDER BY p.sumd ASC, p.sumu DESC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
			case 'nd':
				$query .= "ORDER BY p.sumd DESC, p.sumu ASC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
				break;
		}
  				
		$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$idx = 1;
		$statement->bindValue($idx++, $convocatoria_id);
		if ($partido_id){
			$statement->bindValue($idx++, $partido_id);
		}
		if ($geoName){
			$statement->bindValue($idx++, $geoName);
		}			
		$statement->execute();
		
		$this->politicos = $statement->fetchAll(PDO::FETCH_CLASS, 'Candidato');
  	//echo (time()-$initTime). "-5 ($convocatoria_id , $partido_id , $geoName , $order)<br>";
  	}
  					
	$this->numEscanyos = false;
  }

  public function getPoliticos() {
  	return $this->politicos;
  }
  
  public function getEscanyos($minSumu, $minSumd, $lastDate, $apellidos) {
  	$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
	
	if ($cache) {
		$aKey = "Escanyos_". $this->convocatoriaId ."-". $this->partidoId ."-". $this->geoName ."-$minSumu-$minSumd-$lastDate-$apellidos";
		$key=md5( $aKey );
		$data = unserialize($cache->get($key));
	}
	else {
		$data = false;
	}
	
	if (!$data){
		//echo "($aKey-$key)";
		  if ($this->geoName){
		  	if (!$this->numEscanyos) {
				$this->numEscanyos = 0;
				foreach($this->politicos as $politico){
					if (
						$politico->getSumu() > $minSumu || 
						($politico->getSumu() == $minSumu && $politico->getSumd() < $minSumd) ||
						($politico->getSumu() == $minSumu && $politico->getSumd() == $minSumd && $politico->getLastDate() > $lastDate && $minSumu != 0) ||
						($politico->getSumu() == $minSumu && $politico->getSumd() == $minSumd && $politico->getLastDate() == $lastDate && $politico->getApellidos() > $apellidos && $minSumu != 0) 
						){
							//echo "(".$politico->getApellidos().",".$politico->getSumu().",".$politico->getSumd().",".$politico->getLastDate().")";
							$this->numEscanyos++;
					}
				}
		  	}
	  	}
	  	else { 
		    // Circus
		  	$c = new Criteria();
		  	$c->addJoin(ListaPeer::CIRCUNSCRIPCION_ID, CircunscripcionPeer::ID);
		  	$c->addJoin(CircunscripcionPeer::GEO_ID, GeoPeer::ID);
		  	$c->add(ListaPeer::CONVOCATORIA_ID, $this->convocatoriaId);
		  	$c->addAscendingOrderByColumn(GeoPeer::NOMBRE);
		  	$c->setDistinct();
		  	$circus = CircunscripcionPeer::doSelect( $c );
			$this->numEscanyos = 0;
		  	foreach ($circus as $circu){	  		
				$listaElectoral = new ListaElectoral($this->convocatoriaId, $this->partidoId, $circu->getGeo()->getNombre());
				$res = $this->convocatoria->getResults($circu->getGeo()->getNombre(), false);
				$sum = $listaElectoral->getEscanyos($res['minSumu'], $res['minSumd'], $res['lastDate'], $res['apellidos']);
				$this->numEscanyos += $sum;
		  	}
	  	}		
	  	
	  	$data = $this->numEscanyos;
	  	
		if ($cache) {
			$cache->set($key, serialize($data?$data:"zero"), 3600);
		}
	}
	
	return $data == "zero"?0:$data;
  }
}	  
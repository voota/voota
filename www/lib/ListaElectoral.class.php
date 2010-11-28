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
  	$this->geoName = $geoName;
  	$this->convocatoriaId = $convocatoria_id;
  	$this->partidoId = $partido_id;
  	$this->convocatoria = ConvocatoriaPeer::retrieveByPK($convocatoria_id);

  	if ($this->convocatoria->getClosedAt()){
		$query = "SELECT DISTINCT p.id, p.vanity, p.nombre, p.apellidos, p.imagen, l.sumu, l.sumd, r.last_date lastDate, p.sf_guard_user_id
			FROM politico p
			INNER JOIN sf_guard_user u ON u.id = p.sf_guard_user_id
			INNER JOIN sf_guard_user_profile up ON u.id = up.id
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
		$query .= "ORDER BY l.sumu DESC, l.sumd ASC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
  				
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
		$query .= "ORDER BY p.sumu DESC, p.sumd ASC, r.last_date DESC, p.apellidos ASC, p.nombre ASC;";
  				
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
  					
	$this->numEscanyos = false;
  }

  public function getPoliticos() {
  	return $this->politicos;
  }
  
  public function getEscanyos($minSumu, $minSumd, $lastDate, $apellidos) {
  	$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
	
	if ($cache) {
		
		$key=md5("Escanyos_". $this->convocatoriaId ."-". $this->partidoId ."-". $this->geoName ."");
		$data = unserialize($cache->get($key));
	}
	else {
		$data = false;
	}
	if (!$data){
		  if ($this->geoName){
		  	if (!$this->numEscanyos) {
				$this->numEscanyos = 0;
				foreach($this->politicos as $politico){
					if (
						$politico->getSumu() > $minSumu || 
						($politico->getSumu() == $minSumu && $politico->getSumd() < $minSumd) ||
						($politico->getSumu() == $minSumu && $politico->getSumd() == $minSumd && $politico->getLastDate() > $lastDate) ||
						($politico->getSumu() == $minSumu && $politico->getSumd() == $minSumd && $politico->getLastDate() == $lastDate && $politico->getApellidos() > $apellidos) 
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
			$cache->set($key, serialize($data), 3600);
		}
	}
	
	return $data;
		

  		
  	return $this->numEscanyos;
  }
}	  
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
  	$this->convocatoria = ConvocatoriaPeer::retrieveByPK($convocatoria_id);

  	if ($this->convocatoria->getClosedAt()){
		$query = "SELECT DISTINCT p.id, p.vanity, p.nombre, p.apellidos, p.imagen, l.sumu, l.sumd, r.last_date lastDate
			FROM politico p
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
  	//echo "($minSumu, $minSumd, $lastDate, $apellidos)";
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
  		
  	return $this->numEscanyos;
  }
}	  
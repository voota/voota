<?php

/*
 * This file is part of the symfony package.
 * (c) Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Sergio Viteri <sergio@voota.es>
 * @version    SVN: $Id: sfReviewRouting.class.php 13346 2009-09-09 12:10:17Z Sergio $
 */
class SfReviewManager extends BaseSfReviewManager
{
	static function getActivityQuery($filter){
		$type_id = false;
		$entity_id = false;
		$offset = false;
		$textFilter = false;
		$culture = false;
		$userId = false;
		
		if ( isset($filter['type_id']) ){
			$type_id = $filter['type_id'];
		}
		if ( isset($filter['entity_id']) ){
			$entity_id = $filter['entity_id'];
		}
		if ( isset($filter['offset']) ){
			$criteria->setOffset( $filter['offset'] );
		}
		if ( isset($filter['offset']) ){
			$ffset = $filter['offset'];
		}		
	  	if(isset($filter['textFilter'])){
	  		$textFilter = $filter['textFilter'];
	  	}
	  	if(isset($filter['culture'])){
	  		$culture = $filter['culture'];
	  	}
	  	if(isset($filter['userId'])){
	  		$userId = $filter['userId'];
	  	}
	  	
		$query = "
			(
			SELECT 1 mode, IFNULL(modified_at, created_at) date, sf_review_type_id type, culture, r.text
			, r.sf_guard_user_id
			, r.id
			, r.value
			, r.entity_id
			, r.sf_review_status_id
			, r.sf_review_id
			, anonymous
			FROM sf_review  r
			WHERE is_active = 1 ";
		
		if ($type_id != "null"){
			$query .= "
			
			UNION
			
			SELECT 
			2 mode
			, (CASE WHEN ep.fecha IS NOT NULL THEN ep.fecha WHEN epa.fecha IS NOT NULL THEN epa.fecha WHEN epr.fecha IS NOT NULL THEN epr.fecha END) date
			, (CASE WHEN ep.fecha IS NOT NULL THEN 1 WHEN epa.fecha IS NOT NULL THEN 2 WHEN epr.fecha IS NOT NULL THEN 3 END) type
			, e.culture, e.texto text
			, (CASE WHEN ep.sf_guard_user_id IS NOT NULL THEN ep.sf_guard_user_id WHEN epa.sf_guard_user_id IS NOT NULL THEN epa.sf_guard_user_id WHEN epr.sf_guard_user_id IS NOT NULL THEN epr.sf_guard_user_id END) sf_guard_user_id
			, e.id
			, 0 value
			, (CASE WHEN ep.fecha IS NOT NULL THEN ep.politico_id WHEN epa.fecha IS NOT NULL THEN epa.partido_id WHEN epr.fecha IS NOT NULL THEN epr.propuesta_id END) entity_id
			, 1 status_id
			, null sf_review_id
			, 0 anonymous
			FROM etiqueta e
			LEFT JOIN voota.etiqueta_politico ep on e.id = ep.etiqueta_id
			LEFT JOIN voota.etiqueta_partido epa on e.id = epa.etiqueta_id
			LEFT JOIN voota.etiqueta_propuesta epr on e.id = epr.etiqueta_id ";	
		}
		
		$query .= " ) actividad ";
		
		$query .= " WHERE 1 = 1 ";	
	
		if ($entity_id){
		  	if ($type_id) {
				$query .= " AND entity_id = ? ";	
		  	}
		  	else {
				$query .= " AND sf_review_id = ? ";	
		  	}
		}		
		if ($type_id) {	
		  	if ($type_id == "null"){
				$query .= " AND type IS NULL ";	
		  	}
		  	else {
				$query .= " AND type = ? ";	
		  	}  	
		}
			
		//$query .= $type_id?" AND type = ? ":"";	
		//$query .= $entity_id?" AND entity_id = ? ":"";	
		$query .= $textFilter?" AND text IS NOT NULL ":"";
		$query .= $culture?" AND culture = ? ":"";
		$query .= $userId?" AND sf_guard_user_id = ? ":"";
		
		return $query;
	}
	
	static function getActivities($filter, $page = 1, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS) {
		$type_id = false;
		$entity_id = false;
		$offset = false;
		$textFilter = false;
		$culture = false;
		$userId = false;
		
		if ( isset($filter['type_id']) ){
			$type_id = $filter['type_id'];
		}
		if ( isset($filter['entity_id']) ){
			$entity_id = $filter['entity_id'];
		}
		if ( isset($filter['offset']) ){
			$criteria->setOffset( $filter['offset'] );
		}
		if ( isset($filter['offset']) ){
			$ffset = $filter['offset'];
		}		
	  	if(isset($filter['textFilter'])){
	  		$textFilter = $filter['textFilter'];
	  	}
	  	if(isset($filter['culture'])){
	  		$culture = $filter['culture'];
	  	}
	  	if(isset($filter['userId'])){
	  		$userId = $filter['userId'];
	  	}
	  	
	  	$offset = $numberOfResults * ($page - 1);
	  	
		$query = "SELECT * FROM ".self::getActivityQuery($filter) . " ORDER BY date DESC LIMIT $numberOfResults OFFSET $offset ";
		
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		//$statement->bindValue(1, $culture);
		$idx = 1;
	
		if ($entity_id){
		  	if ($type_id) {
				$statement->bindValue($idx++, $entity_id);
		  	}
		  	else {
				$statement->bindValue($idx++, $entity_id);	
		  	}
		}		
		if ($type_id) {	
		  	if ($type_id != "null"){
				$statement->bindValue($idx++, $type_id);
		  	}  	
		}
		/*if ($textFilter)
			$statement->bindValue($idx++, $textFilter);*/
		if ($culture)
			$statement->bindValue($idx++, $culture);
		if ($userId)
			$statement->bindValue($idx++, $userId);
		
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_CLASS, 'Activity');		
	}
	
	static function getActivitiesCount($filter) {
		$type_id = false;
		$entity_id = false;
		$offset = false;
		$textFilter = false;
		$culture = false;
		$userId = false;
		
		if ( isset($filter['type_id']) ){
			$type_id = $filter['type_id'];
		}
		if ( isset($filter['entity_id']) ){
			$entity_id = $filter['entity_id'];
		}
		if ( isset($filter['offset']) ){
			$criteria->setOffset( $filter['offset'] );
		}
		if ( isset($filter['offset']) ){
			$ffset = $filter['offset'];
		}		
	  	if(isset($filter['textFilter'])){
	  		$textFilter = $filter['textFilter'];
	  	}
	  	if(isset($filter['culture'])){
	  		$culture = $filter['culture'];
	  	}
	  	if(isset($filter['userId'])){
	  		$userId = $filter['userId'];
	  	}
			  	
		$query = "SELECT count(*) as count FROM ".self::getActivityQuery($filter);
		
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$idx = 1;
		if ($entity_id){
		  	if ($type_id) {
				$statement->bindValue($idx++, $entity_id);
		  	}
		  	else {
				$statement->bindValue($idx++, $entity_id);	
		  	}
		}		
		if ($type_id) {	
		  	if ($type_id != "null"){
				$statement->bindValue($idx++, $type_id);
		  	}  	
		}
		if ($culture)
			$statement->bindValue($idx++, $culture);
		if ($userId)
			$statement->bindValue($idx++, $userId);
		$statement->execute();
				
		$results = $statement->fetchAll(PDO::FETCH_OBJ);
		
		return $results[0]->count;		
	}
}

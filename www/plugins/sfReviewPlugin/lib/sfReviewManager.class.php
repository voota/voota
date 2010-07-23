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
	static function getActivities($filter, $page = 1, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS) {
		$culture = false;
	  	if(isset($filter['culture'])){
	  		$culture = $filter['culture'];
	  	}
	  	$offset = $numberOfResults * ($page - 1);
	  	
		$query = "
			SELECT * FROM 

			(
			SELECT 1 mode, IFNULL(modified_at, created_at) date, sf_review_type_id type, culture, r.text
			, r.sf_guard_user_id
			, r.id
			, r.value
			, r.entity_id
			, r.sf_review_status_id
			, r.sf_review_id
			FROM sf_review  r
			WHERE is_active = 1
			
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
			FROM etiqueta e
			LEFT JOIN voota.etiqueta_politico ep on e.id = ep.etiqueta_id
			LEFT JOIN voota.etiqueta_partido epa on e.id = epa.etiqueta_id
			LEFT JOIN voota.etiqueta_propuesta epr on e.id = epr.etiqueta_id
			) actividad
		";	
		$query .= $culture?" WHERE culture = ? ":"";
		
		$query .= " 
			ORDER BY date DESC
			LIMIT $numberOfResults OFFSET $offset
		";
		
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$statement->bindValue(1, $culture);
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_CLASS, 'Activity');		
	}
}

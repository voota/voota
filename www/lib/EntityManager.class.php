<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class EntityManager {	
  	public static function getTopEntities($limit = 6, &$exclude = "")
  	{
	   	$query = "SELECT p.*, sum(value = 1) sumut, sum(value = -1) sumdt, count(*) c
	  			FROM politico p
				INNER JOIN sf_review r ON r.entity_id = p.id
				WHERE r.is_active = 1
				AND IFNULL(r.modified_at, r.created_at) > (NOW() - INTERVAL 7 DAY)
				AND r.sf_review_type_id = ". Politico::NUM_ENTITY ."
				GROUP BY p.id
				ORDER BY c desc
				LIMIT $limit";
				//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$statement->execute();
		$politicosMasVotadosUltimamente = $statement->fetchAll(PDO::FETCH_CLASS, 'Politico');
		
		
	   	$query = "SELECT p.*, sum(value = 1) sumut, sum(value = -1) sumdt, count(*) c
	  			FROM partido p
				INNER JOIN sf_review r ON r.entity_id = p.id
				WHERE r.is_active = 1
				AND IFNULL(r.modified_at, r.created_at) > (NOW() - INTERVAL 7 DAY)
				AND r.sf_review_type_id = ". Partido::NUM_ENTITY ."
				GROUP BY p.id
				ORDER BY c desc
				LIMIT $limit";
				//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$statement->execute();
		$partidosMasVotadosUltimamente = $statement->fetchAll(PDO::FETCH_CLASS, 'Partido');
  		$entities = array();
  		
		$exclude = "";
		$partidosUsed = array();
		foreach ($politicosMasVotadosUltimamente as $politico) {
				$isPartido = false;
				foreach ($partidosMasVotadosUltimamente as $partido) {
					if (! in_array($partido->getId(), $partidosUsed) && $partido->getTotalt() > $politico->getTotalt() && count($entities) < $limit) {
		    			$entities[] = new Entity( $partido );
		    			$partidosUsed[] = $partido->getId();
		    			$isPartido = true;
					}
				}
				if(!$isPartido && count($entities) < $limit) {
	    			$entities[] = new Entity( $politico );
					$exclude .= ($exclude == ''?'':', ').  $politico->getId();
				}
		}
		foreach ($partidosMasVotadosUltimamente as $partido) {
			if (! in_array($partido->getId(), $partidosUsed) && count($entities) < $limit) {
    			$entities[] = new Entity( $partido );
			}
		}
		
		return $entities;
  	} 
}
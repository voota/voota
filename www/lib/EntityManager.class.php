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
	const PAGE_SIZE = 20;
  
  	public static function getPoliticos($partido, $institucion, $culture, $page = 1, $order = "pd", $limit = self::PAGE_SIZE, &$totalUp, &$totalDown)
  	{
  		$memcache=new sfMemcacheCache();
  		$memcache->initialize();
  		$key=md5("politicos_$partido-$institucion-$culture-$page-$order");
  		$data = $memcache->get($key);
  		if ($data){
  			$totalUp = unserialize($memcache->get("$key-totalUp"));
  			$totalDown = unserialize($memcache->get("$key-totalDown"));	
  			return unserialize($memcache->get("$key"));  		
  		}
  		else {  		
		  	$c = new Criteria();
		  	
		  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID, Criteria::LEFT_JOIN);
		  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
		  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
		  	$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
		  	$c->add(PoliticoPeer::VANITY, null, Criteria::ISNOTNULL);
		  	
		  	if ($partido && $partido != ALL_URL_STRING){
		  		$c->add(PartidoPeer::ABREVIATURA, $partido);
		  	}
		  	if ($institucion && $institucion != ALL_URL_STRING){
		  		$c->add(InstitucionI18nPeer::VANITY, $institucion);
		  	}
		  	$pager = new sfPropelPager('Politico', $limit);
		  	
		  	/* Orden de resultados
		  	 * pa: positivos ascendente
		  	 * pd: positivos descendente
		  	 * na: negativos ascendente
		  	 * nd: negativos descendente
		  	 */
		  	if ($order == "pa"){
		  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMU);
		  	}
		  	else if ($order == "pd") {
		  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
		  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
		  	}
		  	else if ($order == "na"){
		  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
		  	}
		  	else if ($order == "nd") {
		  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMD);
		  		$c->addAscendingOrderByColumn(PoliticoPeer::SUMU);
		  	}
		  	/* Fin Orden */
		  	
			$c->setDistinct();
		    
		    $pager->setCriteria($c);
		    $pager->setPage( $page );
		    $pager->init();
		    
	    	/* Calcula totales. Ver impacto en rendimiento */ 
		    $allPoliticos = PoliticoPeer::doSelect( $c );    
		    $totalUp = 0;
		    $totalDown = 0;
		    foreach ($allPoliticos as $aPolitico){
			    $totalUp += $aPolitico->getSumu();
		    	$totalDown += $aPolitico->getSumd();
		    }
			/* Fin Calcula totales */
		    		    
  			$memcache->set($key,serialize($pager), 3600);
  			$memcache->set("$key-totalUp",serialize($totalUp), 3600);
  			$memcache->set("$key-totalDown",serialize($totalDown), 3600);
	    	return $pager;
  		}
  	}
  	
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
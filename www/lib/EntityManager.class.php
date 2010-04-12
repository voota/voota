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
  
  	public static function getPoliticos($partido, $institucion, $culture, $page = 1, $order = "pd", $limit = self::PAGE_SIZE, &$totalUp = false, &$totalDown = false)
  	{
	  	$cacheManager = sfcontext::getInstance()->getViewCacheManager();
	  	if ($cacheManager != null) {
  			//$cacheManager=new sfMemcacheCache();
  			//$cacheManager->initialize();
  			$key=md5("politicos_$partido-$institucion-$culture-$page-$order");
  			$data = $cacheManager->get($key);
	  	}
	  	else {
	  		$data = false;
	  	}
  		if ($data){
  			$totalUp = unserialize($cacheManager->get("$key-totalUp"));
  			$totalDown = unserialize($cacheManager->get("$key-totalDown"));	
  			return unserialize($cacheManager->get("$key"));  		
  		}
  		else {  		
		  	$c = new Criteria();
		  	
		  	$c->setDistinct();
		  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID, Criteria::LEFT_JOIN);
		  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
		  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
		  	$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
		  	$c->add(PoliticoPeer::VANITY, null, Criteria::ISNOTNULL);		  	
			$c->addJoin(
				array(PoliticoPeer::ID, PoliticoI18nPeer::CULTURE),
				array (PoliticoI18nPeer::ID, "'$culture'")
				, Criteria::LEFT_JOIN
			);
		  			  	
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
		  	
			//$c->setDistinct();
		    
	    	/* Calcula totales. Ver impacto en rendimiento */
  			$query = "SELECT sum(politico.sumu) as total_u, sum(politico.sumd) as total_d 
  				FROM `politico`
  				INNER JOIN `politico_institucion` ON politico_institucion.POLITICO_ID=politico.ID
  				INNER JOIN `institucion` ON institucion.ID=politico_institucion.INSTITUCION_ID 
  				INNER JOIN `institucion_i18n` ON (institucion.ID=institucion_i18n.ID AND institucion_i18n.culture = '$culture')
  				LEFT JOIN partido ON (politico.PARTIDO_ID=partido.ID) 
  				WHERE politico.VANITY IS NOT NULL ".
  				(($partido && $partido != ALL_URL_STRING)?" AND partido.ABREVIATURA='$partido' ":" ") .
  				(($institucion && $institucion != ALL_URL_STRING)?"AND institucion_i18n.VANITY='$institucion' ":" ") .
  				"";
		   	$connection = Propel::getConnection();
			$statement = $connection->prepare($query);
			$statement->execute();
			$results = $statement->fetchAll();
			foreach($results as $result){
				$totalUp = $result['total_u'];
				$totalDown = $result['total_d'];
			}					  	
			/* Fin Calcula totales */
		    
		    $pager->setCriteria($c);
		    $pager->setPage( $page );
		    $pager->init();		    
		    
	  		if ($cacheManager != null) {
	  			$cacheManager->set($key,serialize($pager), 3600);
	  			$cacheManager->set("$key-totalUp",serialize($totalUp), 3600);
	  			$cacheManager->set("$key-totalDown",serialize($totalDown), 3600);
	  		}
	    	return $pager;
  		}
  	}
  	
  	public static function getPropuestas($culture, $page = 1, $order = "pd", $limit = self::PAGE_SIZE, &$totalUp = false, &$totalDown = false)
  	{
	  	$cacheManager = sfcontext::getInstance()->getViewCacheManager();
	  	if ($cacheManager != null) {
  			//$cacheManager=new sfMemcacheCache();
  			//$cacheManager->initialize();
  			$key=md5("propuestas_$partido-$institucion-$culture-$page-$order");
  			$data = $cacheManager->get($key);
	  	}
	  	else {
	  		$data = false;
	  	}
  		if ($data){
  			$totalUp = unserialize($cacheManager->get("$key-totalUp"));
  			$totalDown = unserialize($cacheManager->get("$key-totalDown"));	
  			return unserialize($cacheManager->get("$key"));  		
  		}
  		else {  		
		  	$c = new Criteria();
		  	
		  	$c->setDistinct();
		  	$pager = new sfPropelPager('Propuesta', $limit);
		  	
		  	/* Orden de resultados
		  	 * pa: positivos ascendente
		  	 * pd: positivos descendente
		  	 * na: negativos ascendente
		  	 * nd: negativos descendente
		  	 */
		  	if ($order == "pa"){
		  		$c->addAscendingOrderByColumn(PropuestaPeer::SUMU);
		  	}
		  	else if ($order == "pd") {
		  		$c->addDescendingOrderByColumn(PropuestaPeer::SUMU);
		  		$c->addAscendingOrderByColumn(PropuestaPeer::SUMD);
		  	}
		  	else if ($order == "na"){
		  		$c->addAscendingOrderByColumn(PropuestaPeer::SUMD);
		  	}
		  	else if ($order == "nd") {
		  		$c->addDescendingOrderByColumn(PropuestaPeer::SUMD);
		  		$c->addAscendingOrderByColumn(PropuestaPeer::SUMU);
		  	}
		  	/* Fin Orden */
		  	
			//$c->setDistinct();
		    
	    	/* Calcula totales. Ver impacto en rendimiento */
  			$query = "SELECT sum(propuesta.sumu) as total_u, sum(propuesta.sumd) as total_d 
  				FROM `propuesta` ".
  				"";
		   	$connection = Propel::getConnection();
			$statement = $connection->prepare($query);
			$statement->execute();
			$results = $statement->fetchAll();
			foreach($results as $result){
				$totalUp = $result['total_u'];
				$totalDown = $result['total_d'];
			}					  	
			/* Fin Calcula totales */
		    
		    $pager->setCriteria($c);
		    $pager->setPage( $page );
		    $pager->init();		    
		    
	  		if ($cacheManager != null) {
	  			$cacheManager->set($key,serialize($pager), 3600);
	  			$cacheManager->set("$key-totalUp",serialize($totalUp), 3600);
	  			$cacheManager->set("$key-totalDown",serialize($totalDown), 3600);
	  		}
	    	return $pager;
  		}
  	}
  	
  	public static function getPartidos($institucion, $culture, $page = 1, $order = "pd", $limit = self::PAGE_SIZE, &$totalUp = false, &$totalDown = false)
  	{
	  	$cacheManager = sfcontext::getInstance()->getViewCacheManager();
	  	if ($cacheManager != null) {
  			//$cacheManager=new sfMemcacheCache();
  			//$cacheManager->initialize();
  			$key=md5("partidos_$partido-$institucion-$culture-$page-$order");
  			$data = $cacheManager->get($key);
	  	}
	  	else {
	  		$data = false;
	  	}
  		if ($data){
  			$totalUp = unserialize($cacheManager->get("$key-totalUp"));
  			$totalDown = unserialize($cacheManager->get("$key-totalDown"));	
  			return unserialize($cacheManager->get("$key"));  		
  		}
  		else {  		
		  	$c = new Criteria();
		  	
		  	$c->setDistinct();
			$c->addJoin(
				array(PartidoPeer::ID, PartidoI18nPeer::CULTURE),
				array(PartidoI18nPeer::ID, "'$culture'")
				, Criteria::LEFT_JOIN
			);
		  			  	
		  	if ($institucion && $institucion != ALL_URL_STRING){
		  		$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID);
			  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
			  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
			  	$c->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID);
				$c->addJoin(
					array(InstitucionPeer::ID, InstitucionI18nPeer::CULTURE),
					array(InstitucionI18nPeer::ID, "'$culture'")
					, Criteria::LEFT_JOIN
				);
		  		$c->add(InstitucionI18nPeer::VANITY, $institucion);
		  	}
		  	
		  	$pager = new sfPropelPager('Partido', $limit);
		  	
		  	/* Orden de resultados
		  	 * pa: positivos ascendente
		  	 * pd: positivos descendente
		  	 * na: negativos ascendente
		  	 * nd: negativos descendente
		  	 */
		  	if ($order == "pa"){
		  		$c->addAscendingOrderByColumn(PartidoPeer::SUMU);
		  	}
		  	else if ($order == "pd") {
		  		$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
		  		$c->addAscendingOrderByColumn(PartidoPeer::SUMD);
		  	}
		  	else if ($order == "na"){
		  		$c->addAscendingOrderByColumn(PartidoPeer::SUMD);
		  	}
		  	else if ($order == "nd") {
		  		$c->addDescendingOrderByColumn(PartidoPeer::SUMD);
		  		$c->addAscendingOrderByColumn(PartidoPeer::SUMU);
		  	}
		  	/* Fin Orden */
		  	
			//$c->setDistinct();
		    
	    	/* Calcula totales. Ver impacto en rendimiento */
  			$query = "SELECT sum(partido.sumu) as total_u, sum(partido.sumd) as total_d 
  				FROM `partido` ".
  				(($institucion && $institucion != ALL_URL_STRING)?"INNER JOIN `politico` ON partido.ID=politico.Partido_ID
  				INNER JOIN `politico_institucion` ON politico_institucion.Politico_ID = politico.ID
  				INNER JOIN `institucion` ON institucion.ID = politico_institucion.institucion_id
  				INNER JOIN `institucion_i18n` ON (institucion.ID=institucion_i18n.ID AND institucion_i18n.culture = '$culture') ":" ").
  				(($institucion && $institucion != ALL_URL_STRING)?"AND institucion_i18n.VANITY='$institucion' ":" ") .
  				"";
		   	$connection = Propel::getConnection();
			$statement = $connection->prepare($query);
			$statement->execute();
			$results = $statement->fetchAll();
			foreach($results as $result){
				$totalUp = $result['total_u'];
				$totalDown = $result['total_d'];
			}					  	
			/* Fin Calcula totales */
		    
		    $pager->setCriteria($c);
		    $pager->setPage( $page );
		    $pager->init();		    
		    
	  		if ($cacheManager != null) {
	  			$cacheManager->set($key,serialize($pager), 3600);
	  			$cacheManager->set("$key-totalUp",serialize($totalUp), 3600);
	  			$cacheManager->set("$key-totalDown",serialize($totalDown), 3600);
	  		}
	    	return $pager;
  		}
  	}
  	
  	public static function getTopEntities($limit = 6, &$exclude = "", $entityClass = 'Entity')
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
		    			$entities[] = new $entityClass( $partido );
		    			$partidosUsed[] = $partido->getId();
		    			$isPartido = true;
					}
				}
				if(count($entities) < $limit) {
	    			$entities[] = new $entityClass( $politico );
					$exclude .= ($exclude == ''?'':', ').  $politico->getId();
				}
		}
		foreach ($partidosMasVotadosUltimamente as $partido) {
			if (! in_array($partido->getId(), $partidosUsed) && count($entities) < $limit) {
    			$entities[] = new $entityClass( $partido );
			}
		}
		
		return $entities;
  	} 
}
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
	const MAX_PAGES = 10;
  
  	public static function getPoliticos($partido, $institucion, $culture, $page = 1, $order = "pd", $limit = self::PAGE_SIZE, &$totalUp = false, &$totalDown = false)
  	{
	  	$cacheManager = null;//sfcontext::getInstance()->getViewCacheManager();
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
  				(($partido && $partido != ALL_URL_STRING)?" AND partido.ABREVIATURA= ? ":" ") .
  				(($institucion && $institucion != ALL_URL_STRING)?"AND institucion_i18n.VANITY= ? ":" ") .
  				"";
  			
		   	$connection = Propel::getConnection();
			$statement = $connection->prepare($query);

  			$idx = 1;
  			if ($partido && $partido != ALL_URL_STRING) {
				$statement->bindValue($idx++, $partido);  				
  			}
  			if ($institucion && $institucion != ALL_URL_STRING) {
				$statement->bindValue($idx++, $institucion);  				
  			}
  			
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
	  	$cacheManager = null;//sfcontext::getInstance()->getViewCacheManager();
	  	if ($cacheManager != null) {
  			$key= "propuesta/ranking?key=". md5("propuestas-$culture-$page-$order");
  			$key_totalUp= "propuesta/ranking?key-totalUp=". md5("propuestas-$culture-$page-$order");
  			$key_totalDown= "propuesta/ranking?key-totalDown=". md5("propuestas-$culture-$page-$order");
  			$data = $cacheManager->get($key);
	  	}
	  	else {
	  		$data = false;
	  	}
  		if ($data){
			$totalUp = unserialize( $cacheManager->get($key_totalUp) );
			$totalDown = unserialize( $cacheManager->get($key_totalDown) );
  			return unserialize( $cacheManager->get("$key") );  		
  		}
  		else {
		  	$c = new Criteria();
		  	$c->add(PropuestaPeer::IS_ACTIVE, true);
		  	$c->add(PropuestaPeer::CULTURE, $culture);
		  	
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
		  	else if ($order == "fa") {
		  		$c->addAscendingOrderByColumn(PropuestaPeer::CREATED_AT);
		  	}
		  	else if ($order == "fd") {
		  		$c->addDescendingOrderByColumn(PropuestaPeer::CREATED_AT);
		  	}
		  	/* Fin Orden */
		  	
			//$c->setDistinct();
		    
	    	/* Calcula totales. Ver impacto en rendimiento */
  			$query = "SELECT sum(propuesta.sumu) as total_u, sum(propuesta.sumd) as total_d 
  				FROM `propuesta` ".
  				"WHERE propuesta.is_active = 1
  				AND culture = '$culture'";
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
	  			$cacheManager->set($key_totalUp,serialize($totalUp), 3600);
	  			$cacheManager->set($key_totalDown,serialize($totalDown), 3600);
	  		}
	    	return $pager;
  		}
  	}
  	
  	public static function getPartidos($institucion, $culture, $page = 1, $order = "pd", $limit = self::PAGE_SIZE, &$totalUp = false, &$totalDown = false)
  	{
	  	$cacheManager = null;//sfcontext::getInstance()->getViewCacheManager();
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
		  	$c->add(PartidoPeer::IS_ACTIVE, true);
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
  				INNER JOIN `institucion_i18n` ON (institucion.ID=institucion_i18n.ID AND institucion_i18n.culture = ?) ":" ").
  				(($institucion && $institucion != ALL_URL_STRING)?"AND institucion_i18n.VANITY= ? ":" ") .
  				"WHERE partido.is_active = 1";
	
		   	$connection = Propel::getConnection();
			$statement = $connection->prepare($query);
				$statement->bindValue(1, $culture);
  			if ($institucion && $institucion != ALL_URL_STRING){
				$statement->bindValue(2, $institucion);
  			}
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
  	
  	public static function getTopEntities($limit = 6, &$exclude = "", $entityClass = 'Entity', $showPropuestas = false)
  	{
  		$culture = sfContext::getInstance()->getUser()->getCulture();
  		
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
				AND p.is_active = 1
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
  		
	   	$query = "SELECT p.*, sum(value = 1) sumut, sum(value = -1) sumdt, count(*) c
	  			FROM propuesta p
				INNER JOIN sf_review r ON r.entity_id = p.id
				WHERE r.is_active = 1
				AND p.is_active = 1
				AND IFNULL(r.modified_at, r.created_at) > (NOW() - INTERVAL 7 DAY)
				AND r.sf_review_type_id = ". Propuesta::NUM_ENTITY ."
				AND p.culture = '$culture'
				GROUP BY p.id
				ORDER BY c desc
				LIMIT $limit";
				//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		$statement->execute();
		$propuestasMasVotadasUltimamente = $statement->fetchAll(PDO::FETCH_CLASS, 'Propuesta');
		
  		$entities = array();  		
		$exclude = "";
		$partidosUsed = array();
		$idx = 0;
		$idxPolitico = 0;$idxPartido = 0;$idxPropuesta = 0;
		
  			while($idx < $limit){
			$idx++;
			
			$politico = isset($politicosMasVotadosUltimamente[$idxPolitico])?$politicosMasVotadosUltimamente[$idxPolitico]:false;
			$partido = isset($partidosMasVotadosUltimamente[$idxPartido])?$partidosMasVotadosUltimamente[$idxPartido]:false;
			$propuesta = isset($propuestasMasVotadasUltimamente[$idxPropuesta])?$propuestasMasVotadasUltimamente[$idxPropuesta]:false;
			
			if ($showPropuestas && $propuesta && (!$partido || $propuesta->getTotalt() >= $partido->getTotalt()) && (!$politico || $propuesta->getTotalt() >= $politico->getTotalt())){
		    	$entities[] = new $entityClass( $propuesta );
		    	$idxPropuesta++;
			}
			elseif ($partido && (!$politico || $partido->getTotalt() >= $politico->getTotalt())){
		    	$entities[] = new $entityClass( $partido );
		    	$idxPartido++;
			}
			elseif ($politico){
		    	$entities[] = new $entityClass( $politico );
		    	$idxPolitico++;
			}
		}
		
		return $entities;
 	}
 	
 	
  	public static function getDefaultPager($entity){
  		
  	}
  	
 	public static function getPager($entity, $reset = false){
	 	$pager = false;
	 	$user = sfContext::getInstance()->getUser();
	 	$culture = $user->getCulture();
	 	
	  	$filter = $user->getAttribute("filter_".$entity->getType(), false);
	  	if ($reset || !$filter){
		  	$filter = array(
		  		'type' => $entity->getType(),
		  		'partido' => 'all',
		  		'institucion' => '0',
		  		'culture' => $culture,
		  		'page' => '1',
		  		'order' => 'pd',
		  	);
		  	$user->setAttribute("filter_".$entity->getType(), $filter);  		
	  	}  
	  	
	  	switch($entity->getType()){
	  		case Politico::NUM_ENTITY:
	  			$pager = self::getPoliticos($filter['partido'], $filter['institucion'], $filter['culture'], $filter['page'], $filter['order']);
	  			break;
	  		case Partido::NUM_ENTITY:
	  			$pager = self::getPartidos($filter['institucion'], $filter['culture'], $filter['page'], $filter['order']);
	  			break;
	  		case Propuesta::NUM_ENTITY:
	  			$pager = self::getPropuestas($filter['culture'], $filter['page'], $filter['order']);
	  			break;
	  	}
	
	   	$found = false;
	  	$idx=0;
	  	$page = $filter['page'];
	  	$morePages = true;
	  	$lastPage = $pager->getLastPage();
	  	do {
	  		$idx ++;
	  		
		  	foreach ($pager->getResults() as $aEntity){
				if ($aEntity->getId() == $entity->getId()){	
					$found = true;
		  			$filter['page'] = $page;
				}
			}

			if (!$found && $pager->getLastPage() > 1) {
				if ($idx==1 && $page != $filter['page']){
					$page = 0;
				}
				
				switch($idx){
					case 2:
						if ($page > 2){
							$page -= 2;
							break;
						}
					case 3:
						if ($page > 3)
							$page += 2;
						$page += 1;
						break;
					default:
						$page++;
				}
				if ($lastPage > $page) {
					//echo $page;			
					$pager->setPage($page);
					$pager->init();
	  				$user->setAttribute("filter_".$entity->getType(), $filter);
				}
			}
	  	} while (!$found && $idx < self::MAX_PAGES);

	  	if (!$found && $idx < self::MAX_PAGES){
	  		$pager = self::getPager($entity, true);
	  	}
	  	
	  	return $pager; 
  	}
}
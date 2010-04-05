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
  		$culture = sfContext::getInstance()->getUser()->getCulture('es');
  		
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
				array(PoliticoI18nPeer::ID, "'$culture'")
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
		  		$c->addAscendingOrderByColumn(PoliticoI18nPeer::SUMU);
		  	}
		  	else if ($order == "pd") {
		  		$c->addDescendingOrderByColumn(PoliticoI18nPeer::SUMU);
		  		$c->addAscendingOrderByColumn(PoliticoI18nPeer::SUMD);
		  	}
		  	else if ($order == "na"){
		  		$c->addAscendingOrderByColumn(PoliticoI18nPeer::SUMD);
		  	}
		  	else if ($order == "nd") {
		  		$c->addDescendingOrderByColumn(PoliticoI18nPeer::SUMD);
		  		$c->addAscendingOrderByColumn(PoliticoI18nPeer::SUMU);
		  	}
		  	/* Fin Orden */
		  	
			//$c->setDistinct();
		    
	    	/* Calcula totales. Ver impacto en rendimiento */
  			$query = "SELECT sum(sumu) as total_u, sum(sumd) as total_d 
  				FROM `politico`
  				INNER JOIN `politico_institucion` ON politico_institucion.POLITICO_ID=politico.ID
  				INNER JOIN `institucion` ON institucion.ID=politico_institucion.INSTITUCION_ID 
  				INNER JOIN `institucion_i18n` ON (institucion.ID=institucion_i18n.ID AND institucion_i18n.culture = '$culture')
  				INNER JOIN `politico_i18n` ON (politico.ID=politico_i18n.ID AND politico_i18n.culture = '$culture') 
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
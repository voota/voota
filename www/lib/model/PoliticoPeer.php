<?php

class PoliticoPeer extends BasePoliticoPeer
{
	static public function retrieveForAutoSelect($q, $limit)
	{
	  $criteria = new Criteria();
  	  $criterion = $criteria->getNewCriterion(PoliticoPeer::APELLIDOS, '%'.$q.'%', Criteria::LIKE);
	  $criterion->addOr($criteria->getNewCriterion(PoliticoPeer::NOMBRE, '%'.$q.'%', Criteria::LIKE));
	  $criteria->add( $criterion );	
	
	  $criteria->addAscendingOrderByColumn(PoliticoPeer::APELLIDOS);
	  $criteria->setLimit($limit);
	 
	  $instituciones = array();
	  foreach (PoliticoPeer::doSelect($criteria) as $politico)
	  {
	    $politicos[$politico->getId()] = (string) $politico;
	  }
	 
	  return $politicos;
	}
	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		$cache = sfcontext::getInstance()->getViewCacheManager()->getCache();
	  	if ($cache != null) {
			$cacheKey = "pol_count";
			foreach($criteria->keys() as $key){
				$cacheKey .= "_$key";
			}
	  		$key=md5($cacheKey);
  			$data = $cache->get($key);
	  	}
	  	else {
	  		$data = false;
	  	}
  		if ($data){	
  			return unserialize($cache->get("$key"));  		
  		}
  		else {
  			$count = parent::doCount($criteria, $distinct, $con);
			
  			if ($cache != null) {
	  			$cache->set($key,serialize($count)); 
	  		}
	  		
			return $count;
  		}
	}
	
}

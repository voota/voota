<?php

class PartidoPeer extends BasePartidoPeer
{

	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		$cache = sfcontext::getInstance()->getViewCacheManager()->getCache();
	  	if ($cache != null) {
			$cacheKey = "par_count";
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

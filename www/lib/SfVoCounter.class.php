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
 * @subpackage counter
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class SfVoCounter
{
	public static function countPoliticos() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("politicos_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		  	$cpol = new Criteria();
		  	//$cpol->add(SfReviewPeer::CULTURE, $culture);
		  	$cpol->setDistinct();		  	
		  	$data = PoliticoPeer::doCount($cpol);
			
			if ($cache) {
				$cache->set($key, serialize($data), 3600);
			}
		}
		
		return $data;
	}
	
	public static function countPoliticosReviewed() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("politicos_reviewed_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		  	$cpol = new Criteria();
		  	$cpol->addJoin(PoliticoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
		  	$cpol->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Politico::NUM_ENTITY);
		  	$cpol->add(SfReviewPeer::IS_ACTIVE, TRUE);
		  	//$cpol->add(SfReviewPeer::CULTURE, $culture);
		  	$cpol->setDistinct();		  	
		  	$data = PoliticoPeer::doCount($cpol);
			
			if ($cache) {
				$cache->set($key, serialize($data), 360);
			}
		}
		
		return $data;
	}
	
	public static function countPartidos() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("partidos_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		  	$cpar = new Criteria();
		  	$cpar->add(PartidoPeer::IS_ACTIVE, TRUE);
		  	//$cpar->add(SfReviewPeer::CULTURE, $culture);
		  	$cpar->setDistinct();		  	
		  	$data = PartidoPeer::doCount($cpar);
			
			if ($cache) {
				$cache->set($key, serialize($data), 3600);
			}
		}
		
		return $data;
	}
	
	public static function countPartidosReviewed() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("partidos_reviewed_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		  	$cpar = new Criteria();
		  	$cpar->addJoin(PartidoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
		  	$cpar->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Partido::NUM_ENTITY);
		  	$cpar->add(SfReviewPeer::IS_ACTIVE, TRUE);
		  	$cpar->add(PartidoPeer::IS_ACTIVE, TRUE);
		  	//$cpar->add(SfReviewPeer::CULTURE, $culture);
		  	$cpar->setDistinct();		  	
		  	$data = PartidoPeer::doCount($cpar);
			
			if ($cache) {
				$cache->set($key, serialize($data), 360);
			}
		}
		
		return $data;
	}
	
	public static function countPropuestas() {
		$user = sfContext::getInstance()->getUser();
		$culture = $user->getCulture();
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("propuestas_counter_$culture");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		  	$cpro = new Criteria();
		  	$cpro->add(PropuestaPeer::IS_ACTIVE, TRUE);
		  	//$cpro->add(SfReviewPeer::CULTURE, $culture);
		  	$cpro->add(PropuestaPeer::CULTURE, $culture);
		  	$cpro->setDistinct();	  	
		  	$data = PropuestaPeer::doCount($cpro);
			
			if ($cache) {
				$cache->set($key, serialize($data), 360);
			}
		}
		
		return $data;
	}
	
	public static function countPropuestasReviewed() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("propuestas_reviewes_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		 	$user = sfContext::getInstance()->getUser();
		 	$culture = $user->getCulture();
		  	$cpro = new Criteria();
		  	$cpro->addJoin(PropuestaPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
		  	$cpro->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Propuesta::NUM_ENTITY);
		  	$cpro->add(SfReviewPeer::IS_ACTIVE, TRUE);
		  	$cpro->add(PropuestaPeer::IS_ACTIVE, TRUE);
		  	//$cpro->add(SfReviewPeer::CULTURE, $culture);
		  	$cpro->add(PropuestaPeer::CULTURE, $culture);
		  	$cpro->setDistinct();	  	
		  	$data = PropuestaPeer::doCount($cpro);
			
			if ($cache) {
				$cache->set($key, serialize($data), 360);
			}
		}
		
		return $data;
	}
	
	public static function countReviews() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("reviews_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		 	//$user = sfContext::getInstance()->getUser();
		 	//$culture = $user->getCulture();
		  	$cpos = new Criteria();
		  	$cpos->add(SfReviewPeer::IS_ACTIVE, 1);
		  	//$cpos->add(SfReviewPeer::CULTURE, $culture);
		  	$data = SfReviewPeer::doCount($cpos);
			
			if ($cache) {
				$cache->set($key, serialize($data), 360);
			}
		}
		
		return $data;
	}
	
	public static function countUsers() {
  		$cache = sfcontext::getInstance()->getViewCacheManager()?sfcontext::getInstance()->getViewCacheManager()->getCache():false;
		
		if ($cache) {
			$key=md5("reviews_counter");
			$data = unserialize($cache->get($key));
		}
		else {
			$data = false;
		}
		if (!$data){
		 	//$user = sfContext::getInstance()->getUser();
		 	//$culture = $user->getCulture();

  			$cuser = new Criteria();
  			$cuser->add(sfGuardUserPeer::IS_ACTIVE, 1);

  			$data = sfGuardUserPeer::doCount($cuser);
			
			if ($cache) {
				$cache->set($key, serialize($data), 360);
			}
		}
		
		return $data;
	}
}

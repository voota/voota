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
class BaseSfReviewManager
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
	//const NUM_LAST_REVIEWS = 2;
	const NUM_REVIEWS = 20;
	const MAX_LENGTH = 280;
	
	
	/*
  static public function getLastReviewsByEntityAndValue($request, $type_id, $entity_id, $value = NULL, $numberOfResults = BaseSfReviewManager::NUM_LAST_REVIEWS)
  {
    $criteria = new Criteria();
    $criteria->addJoin(SfReviewPeer::SF_REVIEW_STATUS_ID, SfReviewStatusPeer::ID);
    
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
  	if ($type_id != '') {
  		$criteria->add(SfReviewPeer::ENTITY_ID, $entity_id);  	
  		$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $type_id);  	
  	}
  	else {
  		$criteria->add(SfReviewPeer::SF_REVIEW_ID, $entity_id); 
  	}
    
  	if ($value != NULL){  	  	
  		$criteria->add(SfReviewPeer::VALUE, $value);
  	}
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
  	
  	$pager = new sfPropelPager('SfReview', $numberOfResults);
    $pager->setCriteria($criteria);
    $pager->init();
    return $pager;
  }
  */
  
  static public function getReviewsByUser($userId, $f = false, $page = 1, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS){
	$culture = sfContext::getInstance()->getUser()->getCulture();
	
  	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	
	// Filter entities by culture. Must have 'culture' column and 'culturized' column in sf_review_type must be checked
    $criteria->addJoin(SfReviewPeer::SF_REVIEW_TYPE_ID, SfReviewTypePeer::ID, Criteria::LEFT_JOIN);
  	$cultureCriterion = $criteria->getNewCriterion(SfReviewTypePeer::CULTURIZED, false);
	$cultureCriterion->addOr($criteria->getNewCriterion(SfReviewPeer::CULTURE, $culture));
	$criteria->add( $cultureCriterion );	
	
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $userId);
	$criteria->add(SfReviewPeer::ANONYMOUS, false);
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	if( $f ){
		if (preg_match('/\.0/', $f)){
			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, null, Criteria::ISNULL);
		}
		else if (preg_match('/[0-9]/', $f)){
			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $f);
		}
		$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	}
	  
  	$pager = new sfPropelPager('SfReview', $numberOfResults);
    $pager->setCriteria($criteria);
    $pager->setPage( $page );
    $pager->init();

    return $pager;
  }
	
  static public function getReviewsByEntityAndValue($request, $type_id, $entity_id, $value = false, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS, $exclude = false, $page = false, $offset = 1, $textFilter = false){
  	$filter = array();
  	$filter['type_id'] = $type_id;
  	$filter['entity_id'] = $entity_id;
  	$filter['value'] = $value;
  	$filter['exclude'] = $exclude;
  	$filter['offset'] = $offset;
  	$filter['textFilter'] = $textFilter;
  
    if (! $page) {
	    if ($request){
	    	$page = $request->getParameter($value == 1?'pageU':'pageD', 1);
	    }
	    else{
	    	$page = 1;
	    }
    }
    
  	return self::getReviews($filter, $page, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS);
  }

  static private function getReviewsCriteria($filter)
  {
	    $criteria = new Criteria();
	    $criteria->addJoin(SfReviewPeer::SF_REVIEW_STATUS_ID, SfReviewStatusPeer::ID);
		$criteria->add(SfReviewPeer::IS_ACTIVE, true);
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
	  	if(isset($filter['anonymous'])){
	  		$anonymous = $filter['anonymous'];
	  	}
	  	if(isset($filter['userId'])){
	  		$userId = $filter['userId'];
	  		if ($userId)
	  			$anonymous = false;
	  	}
  
	  	if ($userId){
			$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $userId);
	  	}
	  	if (isset($anonymous)){
			$criteria->add(SfReviewPeer::ANONYMOUS, $anonymous);
	  	}
	  	if ($culture){
	  		$criteria->add(SfReviewPeer::CULTURE, $culture);
	  	}
		if ( $offset )
			$criteria->setOffset( $offset );		
		if ($entity_id){
		  	if ($type_id) {
		  		$criteria->add(SfReviewPeer::ENTITY_ID, $entity_id);
		  	}
		  	else {
		  		$criteria->add(SfReviewPeer::SF_REVIEW_ID, $entity_id);
		  	}
		}		
		if ($type_id) {	
		  	if ($type_id == "null"){
		  		$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, null, Criteria::ISNULL);
		  	}
		  	else {
	  			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $type_id);
		  	}  	
		}
		
	  	if (isset($filter['value']) && $filter['value']){  	  	
	  		$criteria->add(SfReviewPeer::VALUE, $filter['value']);
	  	}
	  	if (isset($filter['exclude']) && $filter['exclude']){
	  		$criteria->add(SfReviewPeer::ID, $exclude, Criteria::NOT_IN);
	  	}	  	
	  	if($textFilter == 'text'){
			$criteria->add(SfReviewPeer::TEXT, '', Criteria::NOT_EQUAL);
			$criteria->add(SfReviewPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture(''));
		}
		
		$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	
	    return $criteria;
  }
  static public function getReviews($filter, $page = 1, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS)
  {
  	if (class_exists('Doctrine')){
  		return Doctrine::getTable('SfReview')->getReviews($filter, $page, $numberOfResults);
  	}
  	else {
  		$pager = new sfPropelPager('SfReview', $numberOfResults);
	    $pager->setCriteria( self::getReviewsCriteria($filter) );
	    
	    $pager->setPage( $page );
	    $pager->init();
	    
	    return $pager;
  	}
  }
  
  static public function getReviewsCount($filter, $page = 1, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS)
  {
		return SfReviewPeer::doCount( self::getReviewsCriteria($filter) );
  }
  
  static public function getTotalReviewsByEntityAndValue($type_id, $entity_id, $value){
	$query = "SELECT COUNT(*) AS count ".
			"FROM %s r ".
			"INNER JOIN %s s ON s.id = r.sf_review_status_id ".
			"WHERE r.is_active = 1 AND r.value = ? ";
			if($type_id != ''){
				$query .= ' AND r.entity_id = ? AND r.sf_review_type_id = ? ';
			}
			else {
				$query .= ' AND r.sf_review_id = ? AND r.sf_review_type_id is null';
			}
	$query = sprintf($query, SfReviewPeer::TABLE_NAME, SfReviewStatusPeer::TABLE_NAME);
	
  	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->bindValue(1, $value);
	$statement->bindValue(2, $entity_id);
	if($type_id != ''){
		$statement->bindValue(3, $type_id);
	}
	
	$statement->execute();
	$row = $statement->fetch();
	
	return $row['count'];
  }
  
  static public function getBalanceByReviewId($id){
	$query = "SELECT SUM(r.value) AS sum ".
			"FROM %s r ".
			"INNER JOIN %s s ON s.id = r.sf_review_status_id ".
			"WHERE r.is_active = 1 AND r.sf_review_id = ? AND r.sf_review_type_id is null";
	$query = sprintf($query, SfReviewPeer::TABLE_NAME, SfReviewStatusPeer::TABLE_NAME);
	
  	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->bindValue(1, $id);
	
	$statement->execute();
	$row = $statement->fetch();
	
	return $row['sum'];
  }
  
  static public function deleteReview($type_id, $entity_id)
  {
  	/*
    $criteria = new Criteria();
    
  	$criteria->add(SfReviewPeer::ENTITY_ID, $entity_id);  	  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $type_id);
  	
  	$review = SfReviewPeer::doSelectOne( $criteria );
  	$review->setIsActive( true );
  	$review->save();  	  	
  	*/
  }
  
  static public function removeReview($id)
  {
  	$criteria = new Criteria();
  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, sfContext::getInstance()->getUser()->getGuardUser()->getId()); 	
  	$criteria->add(SfReviewPeer::ID, $id);	
  	
  	$review = SfReviewPeer::doSelectOne( $criteria );
  	$review->setText('');
  	$review->setIsActive( false );
  	$review->save();  	  	
  }  
  
 static public function deleteReviewById( $id ){
  	// Primero borrar sus opiniones
  	$c = new Criteria();
  	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $id);
  	$reviews = SfReviewPeer::doSelect( $c );
  	foreach ($reviews as $review){
  		$c2 = new Criteria();
  		$c2->add(SfReviewPeer::SF_REVIEW_ID, $review->getId());
  		$c2->add(SfReviewPeer::SF_REVIEW_TYPE_ID, null);
  		SfReviewPeer::doDelete( $c2 );
  	}
  	
  	SfReviewPeer::doDelete( $c );
  }
  
  static public function getLastReviewByUserId( $userId ){
   	$c = new Criteria();
   	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $userId);
   	$c->add(SfReviewPeer::IS_ACTIVE, true);
   	$c->add(SfReviewPeer::ENTITY_ID, null, Criteria::ISNOTNULL);
   	$c->addDescendingOrderByColumn(SfReviewPeer::CREATED_AT);
   	$c->add(SfReviewPeer::TEXT, null, Criteria::ISNOTNULL);
   	$c->add(SfReviewPeer::TEXT, '', Criteria::NOT_EQUAL);
   	
   	return SfReviewPeer::doSelectOne( $c ); 	
  }
  
  static public function getLastReviewOnReviewByUserId( $userId ){
   	$c = new Criteria();
   	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $userId);
   	$c->add(SfReviewPeer::IS_ACTIVE, true);
   	$c->add(SfReviewPeer::ENTITY_ID, null, Criteria::ISNULL);
   	$c->addDescendingOrderByColumn(SfReviewPeer::CREATED_AT);
   	$c->add(SfReviewPeer::TEXT, null, Criteria::ISNOTNULL);
   	$c->add(SfReviewPeer::TEXT, '', Criteria::NOT_EQUAL);
   	
   	return SfReviewPeer::doSelectOne( $c ); 	
  }
  
  static public function postReview( $userId, $typeId, $entityId, $value, $text = false, $entity = false, $rm = false, $fb = '?', $source = '', $anonymous = '?', $tw = '?' ){
  	$prevValue = false;
  	$guessAnonymous = ($anonymous && $anonymous == '?'?true:false);
  	$guessFB = ($fb && $fb == '?'?true:false);
  	$guessTW = ($tw && $tw == '?'?true:false);
  	
  	if ($guessAnonymous){
  		$user = sfGuardUserPeer::retrieveByPK( $userId );
  		if ($user){
  			$anonymous = $user->getProfile()->getAnonymous();
  		} 
  	}
  		
  	if (!$entityId || !$value){  		
  		throw new Exception("Not enough parameters.");
  	}
  	if ($value != -1 && $value != 1){
  		throw new Exception("Invalid data for 'value'.");
  	}
  	
  	// Check if already exists
  	$c = new Criteria;
  	
  	if (!$typeId){
  		$c->add(SfReviewPeer::SF_REVIEW_ID , $entityId);  
  	}
  	else {
  		$c->add(SfReviewPeer::ENTITY_ID, $entityId);  		
  	}
  	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $userId);
  	$c->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $typeId?$typeId:null);
  	
  	$review = SfReviewPeer::doSelectOne( $c );
  	if (!$review){
  		$review = new SfReview;
	  	if (!$typeId){
	  		$review->setSfReviewId($entityId);
	  	}
	  	else {
	  		$review->setEntityId($entityId);	
	  	}
  		$review->setSfReviewTypeId($typeId?$typeId:null);
  		$review->setSfGuardUserId($userId);
  		$review->setCreatedAt(new DateTime());
  		$review->setSource( $source );
	}
  	else {
  		if ($rm && $value == $review->getValue() && $review->getIsActive()) {
  			$review->setIsActive(false);
  		}
  		else {  			
  			$review->setIsActive(true);
  		}
  		$review->setModifiedAt(new DateTime());
   	}   	
  	$review->setValue($value);
  	if ($text) {
  		$aText = SfVoUtil::cutToLength($text, self::MAX_LENGTH, '');
	  	$aText = strip_tags( $aText );
	  	$review->setText( $aText );
  	}
  	$review->setSfReviewStatusId(1);
  	$review->setIpAddress($_SERVER['REMOTE_ADDR']);
  	$review->setCookie( sfContext::getInstance()->getRequest()->getCookie('symfony') );
	$review->setCulture( sfContext::getInstance()->getUser()->getCulture() );
	if (!$guessFB)
		$review->setToFb( $fb );
	if (!$guessTW)
		$review->setToTw( $tw );
	if (!$guessAnonymous || $review->isNew()){
		$review->setAnonymous( $anonymous );
	}
	
  	try {
  		$review->save();
  		
  		if(!$typeId){
			$parentReview = SfReviewPeer::retrieveByPk( $entityId );
			$parentReview->setBalance( SfReviewManager::getBalanceByReviewId( $entityId ) );
			$parentReview->save();  			
  		}
  		if (!$entity){
  			if (! $typeId){
  				$aEntityId = $parentReview->getEntityId();
  				$aTypeId = $parentReview->getSfReviewTypeId();
  			}
  			else {
  				$aTypeId = $typeId;
  				$aEntityId = $entityId;
  			}
  			
  			$reviewType = SfReviewTypePeer::retrieveByPK ( $aTypeId );
  			$peer = $reviewType->getModel() .'Peer';
  			
  			$entity = $peer::retrieveByPK($aEntityId);
  		}
  		
  		$entity->updateCalcs();
  		$entity->save();
  	}
  	catch (Exception $e){
  		throw new Exception('Error writing review.');
  	}
  	
  	return $review->getIsActive()?$review:false;
  }  
}

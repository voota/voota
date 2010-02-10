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
	const NUM_LAST_REVIEWS = 2;
	const NUM_REVIEWS = 20;
	
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
  
  static public function getReviewsByEntityAndValue($request, $type_id, $entity_id, $value = NULL, $numberOfResults = BaseSfReviewManager::NUM_REVIEWS, $exclude = false, $page = false)
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
  	if ($exclude){
  		$criteria->add(SfReviewPeer::ID, $exclude, Criteria::NOT_IN);
  	}
  	$criteria->addDescendingOrderByColumn("((text <> '') and (culture IS NULL OR culture = '".sfContext::getInstance()->getUser()->getCulture('es')."'))");
  	$criteria->addDescendingOrderByColumn( SfReviewPeer::BALANCE );
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");

  	$pager = new sfPropelPager('SfReview', $numberOfResults);
    $pager->setCriteria($criteria);
    if ($page) {
    	$pager->setPage( $page );
    }
    else {
	    if ($request)
	    	$pager->setPage($request->getParameter($value == 1?'pageU':'pageD', 1));
    }
    $pager->init();
    return $pager;
  	  	
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
}

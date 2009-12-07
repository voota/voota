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
  static public function getReviewsByEntityAndValue($request, $type_id, $entity_id, $value = NULL, $numberOfResults = 30)
  {
    $criteria = new Criteria();
    $criteria->addJoin(SfReviewPeer::SF_REVIEW_STATUS_ID, SfReviewStatusPeer::ID);
	
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
  	//$criteria->add(SfReviewStatusPeer::PUBLISHED, 1);
  	$criteria->addDescendingOrderByColumn("((text <> '') and (culture IS NULL OR culture = '".sfContext::getInstance()->getUser()->getCulture('es')."'))");
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
  	
  	/*
	return SfReviewPeer::doSelect($criteria);
	*/
  	$pager = new sfPropelPager('SfReview', $numberOfResults);
    $pager->setCriteria($criteria);
    if ($request)
    	$pager->setPage($request->getParameter($value == 1?'pageU':'pageD', 1));
    $pager->init();
    return $pager;
  	  	
  }
  
  static public function getTotalReviewsByEntityAndValue($type_id, $entity_id, $value){
	$query = "SELECT COUNT(*) AS count ".
			"FROM %s r ".
			"INNER JOIN %s s ON s.id = r.sf_review_status_id ".
			"WHERE r.value = ? ";
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
  static public function deleteReview($type_id, $entity_id)
  {
    $criteria = new Criteria();
    
  	$criteria->add(SfReviewPeer::ENTITY_ID, $entity_id);  	  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $type_id);
  	
  	SfReviewPeer::doDelete( $criteria );
  	  	
  }
  
 static public function deleteReviewById( $id ){
  	// Primero borrar sus opiniones
  	$c = new Criteria();
  	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $id);
  	SfReviewPeer::doDelete( $c );
  }
  
}

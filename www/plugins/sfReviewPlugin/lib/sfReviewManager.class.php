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
class SfReviewManager
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function getReviewsByEntityAndValue(sfWebRequest $request, $type_id, $entity_id, $value)
  {
    $criteria = new Criteria();
    $criteria->addJoin(SfReviewPeer::SF_REVIEW_STATUS_ID, SfReviewStatusPeer::ID);
    
  	$criteria->add(SfReviewPeer::ENTITY_ID, $entity_id);  	  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $type_id);
  	$criteria->add(SfReviewPeer::VALUE, $value);
  	//$criteria->add(SfReviewStatusPeer::PUBLISHED, 1);
	$criteria->addDescendingOrderByColumn(SfReviewPeer::CREATED_AT);
  	
  	/*
	return SfReviewPeer::doSelect($criteria);
	*/
  	$pager = new sfPropelPager('SfReview', 30);
    $pager->setCriteria($criteria);
    $pager->setPage($request->getParameter($value == 1?'pageU':'pageD', 1));
    $pager->init();
    return $pager;
  	  	
  }
  
  static public function getTotalReviewsByEntityAndValue($type_id, $entity_id, $value){
	$query = "SELECT COUNT(*) AS count ".
			"FROM %s r ".
			"INNER JOIN %s s ON s.id = r.sf_review_status_id ".
			"WHERE r.entity_id = ? ".
			"AND r.sf_review_type_id = ? ".
			//"AND s.published = 1 ".
			"AND r.value = ? ";
	$query = sprintf($query, SfReviewPeer::TABLE_NAME, SfReviewStatusPeer::TABLE_NAME);
	
  	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->bindValue(1, $entity_id);
	$statement->bindValue(2, $type_id);
	$statement->bindValue(3, $value);
	
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

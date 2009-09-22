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
  static public function getReviewsByEntityAndValue($type_id, $entity_id, $value)
  {
    $criteria = new Criteria();
  	$criteria->add(SfReviewPeer::ENTITY_ID, $entity_id);  	  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $type_id);
  	$criteria->add(SfReviewPeer::VALUE, $value);
	$criteria->addDescendingOrderByColumn(SfReviewPeer::CREATED_AT);
  	
  	return SfReviewPeer::doSelect($criteria);

  	  	
  }

  
}

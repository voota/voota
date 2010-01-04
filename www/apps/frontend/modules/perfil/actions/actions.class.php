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

class perfilActions extends sfActions
{

  public function executeReviews(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
  	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $this->getUser()->getGuardUser()->getId());
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    $this->reviews->init();
  }
  public function executeShow(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
  	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $this->getUser()->getGuardUser()->getId());
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    $this->reviews->init();
  }
}

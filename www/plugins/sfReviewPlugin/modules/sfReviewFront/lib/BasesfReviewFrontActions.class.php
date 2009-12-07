<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasesfReviewFront actions.
 *
 * @package    Voota
 * @subpackage review
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BasesfReviewFrontActions extends sfActions
{
	const MAX_LENGTH = 280;
  	
  public function executeList(sfWebRequest $request)
  {
  	$this->reviewEntityId = $request->getParameter("e");
  	$this->reviewType = $request->getParameter("t");
  	
  	$this->reviewList = SfReviewManager::getReviewsByEntityAndValue($request, $this->reviewType, $this->reviewEntityId);
  }
  
  public function executeInit(sfWebRequest $request)
  {
  	$this->reviewEntityId = $request->getParameter("e");
  	$box = $request->getParameter("b");
  	$this->reviewType = $request->getParameter("t");
  	if ($box && $box != ''){
  		$this->reviewBox = $box;
  	}
  	if ($this->getUser()->isAuthenticated()) {
	  	$criteria = new Criteria();
	  	$criteria->add(SfReviewPeer::ENTITY_ID, $this->reviewEntityId);  	
	  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
	  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->reviewType);  	
	  	$review = SfReviewPeer::doSelect($criteria);
	  	if ($review) {
	  		$this->forward('sfReviewFront', 'preview');
	  	}
  	}
  }
  
  protected function prepareRedirect( $entityId ){
  }
  
  public function executeForm(sfWebRequest $request)
  {
  	$this->reviewValue = $request->getParameter("v");
  	$this->reviewType = $request->getParameter("t");
  	$this->reviewEntityId = $request->getParameter("e");
  	$this->reviewBox = $request->getParameter("b");
  	$this->reviewText = '';
  	$this->reviewId = '';
  	if ($request->getAttribute("cf") == 1) {
  		$this->cf = 1;	
  	}
  	$this->maxLength = BasesfReviewFrontActions::MAX_LENGTH;
  		
  	if (! $this->getUser()->isAuthenticated()) {
  		$type = SfReviewTypePeer::retrieveByPK($this->reviewType);
  		if ($type){
  			$this->prepareRedirect( $this->reviewEntityId );
  		}  		
  		
  		echo "<script>document.location='".$this->getContext()->getController()->genUrl("@sf_guard_signin", true)."'</script>";die;
  	}
  	
  	$criteria = new Criteria();
  	$t = $request->getParameter("t");
  	if ($t != '') {
  		$criteria->add(SfReviewPeer::ENTITY_ID, $this->reviewEntityId);  	
  		$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->reviewType);  	
  	}
  	else {
  		$criteria->add(SfReviewPeer::SF_REVIEW_ID, $this->reviewEntityId); 
  	}
  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
  	$review = SfReviewPeer::doSelect($criteria);
  	if ($review) {
  		$this->reviewValue = $review[0]->getValue();
  		$this->reviewText = $review[0]->getText();
  		$this->reviewId = $review[0]->getId();
  	}
   }
  
  public function edit(){
  	
  }
	
  public function executePreview(sfWebRequest $request)
  {
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	
  	$this->reviewValue = $request->getParameter("v");
  	$this->reviewType = $request->getParameter("t");
  	$this->reviewEntityId = $request->getParameter("e");
  	$this->reviewText = strip_tags( $request->getParameter("review_text") );
  	$this->reviewBox = $request->getParameter("b");
    	$criteria = new Criteria();
  	$criteria->add(SfReviewPeer::ENTITY_ID, $this->reviewEntityId);  	
  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->reviewType);  	
  	$review = SfReviewPeer::doSelectOne($criteria);
  	if ($review) {
  		$this->reviewValue = $review->getValue();
  		$this->reviewText = $review->getText();
  		$this->reviewId = $review->getId();
  		$this->review = $review;
  	}
  }
  
  	
  public function executeSend(sfWebRequest $request)
  {  	
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	
  	if ($request->getParameter("i") != '') {
	  	$criteria = new Criteria();
	  	$t = $request->getParameter("t");
	  	if ($t != '') {
		  	$criteria->add(SfReviewPeer::ENTITY_ID, $request->getParameter("e"));  	
		  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $t);  	
	  	}
	  	else {
	  		$criteria->add(SfReviewPeer::SF_REVIEW_ID, $request->getParameter("e")); 
	  	}
	  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
	  	$criteria->add(SfReviewPeer::ID, $request->getParameter("i"));	
	  	$reviews = SfReviewPeer::doSelect($criteria);
  		$review = $reviews[0];
  	}
  	else  {
  		$review = new SfReview();
  	}
  	$review->setValue( $request->getParameter("v") );
  	$review->setText( strip_tags( substr($request->getParameter("review_text"), 0, BasesfReviewFrontActions::MAX_LENGTH) ) );
  	$t = $request->getParameter("t");
  	if ($t != '') {
  		$review->setSfReviewTypeId( $t );
  		$review->setEntityId( $request->getParameter("e") );
  	}
  	else {
  		$review->setSfReviewId( $request->getParameter("e") );
  	}
  	$review->setSfReviewStatusId( 1 );
  	$review->setSfGuardUserId( $this->getUser()->getGuardUser()->getId() );
  	$review->setIpAddress($_SERVER['REMOTE_ADDR']);
  	$review->setCookie( $request->getCookie('symfony') );
	$review->setCulture( $this->getUser()->getCulture() );	
  	
  	if ($request->getParameter("i") != '') {
  		if ($review->isModified()) {
  			$review->setModifiedAt( date(DATE_ATOM) );
  			SfReviewPeer::doUpdate($review);
  		}
   	}
  	else {
  		$review->setCreatedAt( date(DATE_ATOM) );
  		SfReviewPeer::doInsert($review);
  	}
  	$this->reviewText = strip_tags( $request->getParameter("review_text") );
  }
  
  public function executeDelete(sfWebRequest $request){
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	if ($request->getParameter("cf") == '') {
  		$request->setAttribute("cf", 1);
	  	$this->forward('sfReviewFront', 'form');
  	}
  	if ($request->getParameter("i") != '') {
	  	$criteria = new Criteria();
	  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId()); 	
	  	$criteria->add(SfReviewPeer::ID, $request->getParameter("i"));	
  		SfReviewPeer::doDelete	($criteria);
  	}
  }
  
}

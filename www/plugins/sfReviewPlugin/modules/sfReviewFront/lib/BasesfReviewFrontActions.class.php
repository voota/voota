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
 * @subpackage review
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BasesfReviewFrontActions extends sfActions
{
	const MAX_LENGTH = 250;
  	
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
  
  
  public function executeForm(sfWebRequest $request)
  {
  	$this->reviewValue = $request->getParameter("v");
  	$this->reviewType = $request->getParameter("t");
  	$this->reviewEntityId = $request->getParameter("e");
  	$this->reviewBox = $request->getParameter("b");
  	$this->reviewText = '';
  	$this->reviewId = '';
  	$this->maxLength = BasesfReviewFrontActions::MAX_LENGTH;
  		
  	if (! $this->getUser()->isAuthenticated()) {
  		$culture = $request->getParameter("sf_culture");
  		$type = SfReviewTypePeer::retrieveByPK($this->reviewType);
  		if ($type){
	  		$rule = "@politico_$culture";
	  		$url = "$rule?id=" . $this->reviewEntityId;		
	  		$this->getUser()->setAttribute('url_back', $url);
	  		$this->getUser()->setAttribute('review_v', $this->reviewValue);
	  		$this->getUser()->setAttribute('review_e', $this->reviewEntityId);
  		}  		
  	
  		
  		echo "<script>document.location='".$this->getContext()->getController()->genUrl("@sf_guard_signin", true)."'</script>";die;
  	}
  	
  	$criteria = new Criteria();
  	$criteria->add(SfReviewPeer::ENTITY_ID, $this->reviewEntityId);  	
  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->reviewType);  	
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
  	$review = SfReviewPeer::doSelect($criteria);
  	if ($review) {
  		$this->reviewValue = $review[0]->getValue();
  		$this->reviewText = $review[0]->getText();
  		$this->reviewId = $review[0]->getId();
  	}
  }
  
  	
  public function executeSend(sfWebRequest $request)
  {  	
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	
  	if ($request->getParameter("i") != '') {
	  	$criteria = new Criteria();
	  	$criteria->add(SfReviewPeer::ENTITY_ID, $request->getParameter("e"));  	
	  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
	  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $request->getParameter("t"));  	
	  	$criteria->add(SfReviewPeer::ID, $request->getParameter("i"));	
  		$reviews = SfReviewPeer::doSelect($criteria);
  		$review = $reviews[0];
  	}
  	else  {
  		$review = new SfReview();
  	}
  	$review->setValue( $request->getParameter("v") );
  	$review->setText( strip_tags( substr($request->getParameter("review_text"), 0, BasesfReviewFrontActions::MAX_LENGTH) ) );
  	$review->setSfReviewTypeId( $request->getParameter("t") );
  	$review->setEntityId( $request->getParameter("e") );
  	$review->setSfReviewStatusId( 1 );
  	$review->setSfGuardUserId( $this->getUser()->getGuardUser()->getId() );
  	$review->setIpAddress($_SERVER['REMOTE_ADDR']);
  	$review->setCookie( $request->getCookie('symfony') );
  	
  	if ($request->getParameter("i") != '') {
  		if ($review->isModified()) {
  			SfReviewPeer::doUpdate($review);
  		}
   	}
  	else {
  		$review->setCreatedAt( date(DATE_ATOM) );
  		SfReviewPeer::doInsert($review);
  	}
  	$this->reviewText = strip_tags( $request->getParameter("review_text") );
  }
}

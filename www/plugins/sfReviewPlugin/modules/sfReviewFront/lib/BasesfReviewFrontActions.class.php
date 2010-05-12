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

  
  public function executeShow(sfWebRequest $request)
  {
  	$id = $request->getParameter("id");
  	
  	$this->review = SfReviewPeer::retrieveByPK( $id );
  	  	
  	$this->forward404Unless( $this->review );
  	
  	if ($this->review->getSfReviewTypeId()) {
	  	$c = new Criteria;
	  	$c->add(SfReviewTypePeer::ID, $this->review->getSfReviewTypeId());
	  	$reviewType = SfReviewTypePeer::doSelectOne( $c );
	  	$peer = $reviewType->getModel() .'Peer';
	  	$c = new Criteria;
	  	$c->add($peer::ID, $this->review->getEntityId());
	  	$this->entity = new Entity($peer::doSelectOne( $c ));   		
  	}
  }
  
  public function executeFilteredList(sfWebRequest $request)
  {
  	$this->entityId = $request->getParameter("entityId");  	
  	$this->value = $request->getParameter("value");  		
  	$this->page = $request->getParameter("page");		
  	$this->sfReviewType = $request->getParameter("sfReviewType");
  	$this->filter = $request->getParameter("filter", false);
  	
  	$c = new Criteria;
  	$c->add(SfReviewTypePeer::ID, $this->sfReviewType);
  	$reviewType = SfReviewTypePeer::doSelectOne( $c );
  	$peer = $reviewType->getModel() .'Peer';
  	$c = new Criteria;
  	$c->add($peer::ID, $this->entityId);
  	$this->entity = $peer::doSelectOne( $c ); 
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
		$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	  	$review = SfReviewPeer::doSelect($criteria);
	  	if ($review) {
	  		$this->forward('sfReviewFront', 'preview');
	  	}
  	}
  	$t = $request->getParameter("t");
	if($t == ''){
  		return "SimpleSuccess";
   	}
  }
  
  protected function prepareRedirect( $entityId, $type ){
  }
  
  public function executeForm(sfWebRequest $request)
  {
  	$this->reviewValue = $request->getParameter("v");
  	$this->reviewType = $request->getParameter("t");
  	$this->reviewEntityId = $request->getParameter("e");
  	$this->reviewBox = $request->getParameter("b");
  	$nl = $request->getParameter("nl");
  	$this->reviewText = '';
  	$this->reviewId = '';
  	if ($request->getAttribute("cf") == 1) {
  		$this->cf = 1;	
  	}
  	$this->maxLength = BasesfReviewFrontActions::MAX_LENGTH;
  	if (! $this->getUser()->isAuthenticated()) {
		//$this->prepareRedirect( $this->reviewEntityId, $this->reviewType );
  		if( $nl == 1 ){
  			$this->prepareRedirect( $this->reviewEntityId, $this->reviewType );
  		}
  		else {
			return 'NotLogged';
  		}
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
  		$this->reviewToFb = $review[0]->getToFb();
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
  	$t = $request->getParameter("t", false);
  	$e = $request->getParameter("e", false);
  	$v = $request->getParameter("v", false);
  	$review_text = $request->getParameter("review_text", false);
  	$fb_publish = $request->getParameter("fb_publish", 0);
  	
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	
  	SfReviewManager::postReview(
  		$this->getUser()->getGuardUser()->getId()
  		, $t, $e, $v, $review_text
  		, false
  		, false
  		, $fb_publish==1?1:0
  		, 'form'
  	);
  	
  	if (!$t ){
		$this->getUser()->setAttribute('sfr_lastvoted_review_id', $e);
   	}
  	
  	$this->reviewText = strip_tags( $review_text );
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
  		SfReviewManager::removeReview( $request->getParameter("i") );
  	}
  }

  public function executeQuickvote(sfWebRequest $request){
  	$typeId = $request->getParameter("t", false);
  	$entityId = $request->getParameter("e", false);
  	$value = $request->getParameter("v", false);
  	$rm = $request->getParameter("rm", false);
  	
  	$this->review = false;
  	
  	$type = SfReviewTypePeer::retrieveByPk( $typeId );
  	if ($type){
  		$peer = $type->getModel() . 'Peer';
  		$this->entity = $peer::retrieveByPK($entityId);
  	}
  	
  	try {  	
  		$this->review = SfReviewManager::postReview($this->getUser()->getGuardUser()->getId(), $typeId, $entityId, $value, false, $this->entity, $rm, 0, 'quick');
  	}
  	catch(Exception $e){
  		echo "fail:". $e->getMessage();
  	}
  }
}

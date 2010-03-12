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
  	
  	$c = new Criteria;
  	$c->add(SfReviewTypePeer::ID, $this->sfReviewType);
  	$reviewType = SfReviewTypePeer::doSelectOne( $c );
  	$peer = $reviewType->getModel() .'Peer';
  	$c = new Criteria;
  	$c->add($peer::ID, $this->entityId);
  	$this->entity = $peer::doSelectOne( $c ); 
  }
  
  public function executeList(sfWebRequest $request)
  {
  	$this->id = $request->getParameter("id");  	
	$this->showCount = $request->getParameter("showCount");
	
  	if (!isset($this->showCount)){
  		$this->showCount = SfReviewManager::NUM_LAST_REVIEWS;
  	}
  	$this->reviewLastList = SfReviewManager::getLastReviewsByEntityAndValue(false, '', $this->id, null, SfReviewManager::NUM_LAST_REVIEWS);
  	$exclude = array();
  	foreach ($this->reviewLastList->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
  	if ($this->showCount > SfReviewManager::NUM_LAST_REVIEWS){
  		$this->reviewList = SfReviewManager::getReviewsByEntityAndValue(false, '', $this->id, null, ($this->showCount - SfReviewManager::NUM_LAST_REVIEWS), $exclude);
  	}
  	
	$this->positiveCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, 1);
	$this->negativeCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, -1);
	$this->total = $this->reviewLastList->getNbResults();// + $this->reviewList->getNbResults();
		
	$this->seeMoreCount = 0;
	if ($this->total > $this->showCount){
		$this->seeMoreCount = ($this->total - $this->showCount)>10?($this->showCount+10):($this->total); 	
	}
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
  	$aText = utf8_decode($request->getParameter("review_text"));
  	$aText = strip_tags( substr($aText, 0, BasesfReviewFrontActions::MAX_LENGTH) );
  	$review->setText( utf8_encode( $aText ) );
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
	$review->setToFb( $request->getParameter("fb_publish")==1?1:0 );	
  	
  	if ($request->getParameter("i") != '') {
  		if ($review->isModified()) {
  			$review->setModifiedAt( date(DATE_ATOM) );
  			//SfReviewPeer::doUpdate($review);
  		}
   	}
  	else {
  		$review->setCreatedAt( date(DATE_ATOM) );
  		//SfReviewPeer::doInsert($review);
  	}
  	$review->setIsActive( true );
  	$review->save();
  	$this->reviewText = strip_tags( $request->getParameter("review_text") );
  	
	if ($t == '') {
		$parentReview = SfReviewPeer::retrieveByPk( $request->getParameter("e") );
		$parentReview->setBalance( SfReviewManager::getBalanceByReviewId( $parentReview->getId() ) );
		$parentReview->save();
	}
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
  
}

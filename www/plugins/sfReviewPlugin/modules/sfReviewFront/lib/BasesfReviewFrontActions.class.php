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
  	if (($goodVanity = SfVoUtil::reviewPermalink($this->review)) != $id){
  		//echo "$goodVanity == $id"; 
  		$this->redirect('sfReviewFront/show?id='.$goodVanity, 301);
  	}
  	  	
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
  	$this->slot = $request->getParameter("slot", false);
  	$this->userId = $request->getParameter("userId", false);
  	
  	// Estabamos vootando antes del login ?
  	$sfr_status = $this->getUser()->getAttribute('sfr_status', false, 'sf_review');
  	if ($sfr_status){
  		$aSfrStatus = array();
  		foreach ($sfr_status as $key => $value){
  			$aSfrStatus[$key] = $value;
  		}
  		$this->sfr_status = $aSfrStatus;
  		$request->setAttribute('sfr_status', $aSfrStatus);
  		$this->getUser()->setAttribute('sfr_status', false, 'sf_review');
  	}
  	else {
  		$this->getUser()->setAttribute('sfr_status', false, 'sf_review');
  		$this->sfr_status = false;
  	}
  	
  	$c = new Criteria;
  	if ($this->sfReviewType) {
  		$c->add(SfReviewTypePeer::ID, $this->sfReviewType);
  	}
  	$reviewType = SfReviewTypePeer::doSelectOne( $c );
  	if ($reviewType) {
	  	$peer = $reviewType->getModel() .'Peer';
	  	$c = new Criteria;
	  	$c->add($peer::ID, $this->entityId);
	  	$this->entity = $peer::doSelectOne( $c );
  	} 
  	
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Pragma: no-cache');
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
  
  protected function prepareRedirect( $request ){
  	$sfr_status = array();
  	$sfr_status['v'] = $request->getParameter("v");
  	$sfr_status['t'] = $request->getParameter("t");
  	$sfr_status['e'] = $request->getParameter("e");
  	$sfr_status['b'] = $request->getParameter("b");
  	$sfr_status['nl'] = $request->getParameter("nl");
  	$sfr_status['pag'] = $request->getParameter("page", 1);
  	$sfr_status['tab'] = $request->getParameter("tab", false);
  	
  	$this->getUser()->setAttribute('sfr_status', $sfr_status, 'sf_review'); 

	//$this->redirect('@sf_guard_signin');
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
  	$this->redirect = false;
  	if (! $this->getUser()->isAuthenticated()) {
  		if( $nl == 1 ){
  			$this->prepareRedirect( $request );
  			$this->redirect = '@sf_guard_signin';
  		}
  		else {
			return 'NotLogged';
  		}
  	}
  	
  	if (!$this->redirect){
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
	  	
	  	if ($this->reviewValue){
		  	SfReviewManager::postReview(
		  		$this->getUser()->getGuardUser()->getId()
		  		, $this->reviewType, $this->reviewEntityId, $this->reviewValue, false
		  		, false
		  		, false
		  		, '?'
		  		, 'form'
		  		, '?'
		  	);
	  	}
	  	
	  	$review = SfReviewPeer::doSelectOne($criteria);
	  	if ($review) {
	  		$this->reviewValue = $review->getValue();
	  		$this->reviewText = $review->getText();
	  		$this->reviewId = $review->getId();
	  		$this->reviewToFb = $review->getToFb();
	  		$this->anonReview = $review->getAnonymous();
	  	}  	
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
  	if($this->reviewType){ 	
  		$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->reviewType);  	
  		$criteria->add(SfReviewPeer::ENTITY_ID, $this->reviewEntityId);
  	}
  	else{
  		$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, null, Criteria::ISNULL);  	
  		$criteria->add(SfReviewPeer::SF_REVIEW_ID, $this->reviewEntityId);
  	}  	
  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId()); 
  	$review = SfReviewPeer::doSelectOne($criteria);
  	if ($review) {
  		$this->reviewValue = $review->getValue();
  		$this->reviewText = $review->getText();
  		$this->reviewId = $review->getId();
  		$this->review = $review;
  	}
  }
  
  	
  public function executeSendTwitter(sfWebRequest $request){
  	$user = $this->getUser();
  	$culture = $user->getCulture();
  	$profile = $user->getGuardUser()->getProfile();
  	$accessToken = $request->getParameter("oauth_verifier", false);
  	
  	// authorize
	if ($accessToken){
		TwitterManager::authorize($this->getUser(), $accessToken);
	}
  	if ($profile->getTwOauthToken() && $profile->getTwOauthTokenSecret()){
  		if (!TwitterManager::verify($this->getUser()) ){
	  		$this->redirect( TwitterManager::requestAuthorization($this->getUser()) );
  			die;
  		}
  	}
	// request auth
	else {
  		try {
  			
	  		$this->redirect( TwitterManager::requestAuthorization($this->getUser()) );
  			die;
  		}
  		catch (Exception $e){
  			die;
  		}
  	}
  }
  
  public function executeSend(sfWebRequest $request)
  {  	
  	$t = $request->getParameter("t", false);
  	$e = $request->getParameter("e", false);
  	$v = $request->getParameter("v", false);
  	
  	$review_text = $request->getParameter("review_text", false);
  	$fb_publish = $request->getParameter("fb_publish", 0);
  	$anon_publish = $request->getParameter("anon_publish", 0);
  	
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
  		, $anon_publish==1?1:0
  	);
  	
  	if (!$t ){
		$this->getUser()->setAttribute('sfr_lastvoted_review_id', $e);
   	}
  	
  	$this->reviewText = strip_tags( $review_text );
  	
  	$this->sendTasks( $request );
  	
  	$this->forward('sfReviewFront', 'preview');  	
  }
  
  public function sendTasks(sfWebRequest $request)
  {  
  
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

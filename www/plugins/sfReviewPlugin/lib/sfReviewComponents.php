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

class sfReviewComponents extends sfComponents
{
	public function executeReviewList(){
		$this->page = $this->page?$this->page:1;
		$this->value = $this->value?$this->value:'';

		
  		$exclude = array();
  		/*
  		$lastReviewsPager = SfReviewManager::getLastReviewsByEntityAndValue(
    							null
    							, $this->sfReviewType
    							, $this->entityId
    							, $this->value?$this->value:null
    							, SfReviewManager::NUM_LAST_REVIEWS
    						);
	    foreach ($lastReviewsPager->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}	  		
  		if ($this->page == 1){
  			$this->lastReviewsPager = $lastReviewsPager ;
  		}
  		*/
  		$this->reviewsPager = SfReviewManager::getReviewsByEntityAndValue(
    							null
    							, $this->sfReviewType
    							, $this->entityId
    							, $this->value?$this->value:null
    							, BaseSfReviewManager::NUM_REVIEWS
    							, $exclude
    							, $this->page
    						);
  		//$this->pageU = $request->getParameter("pageU")+1;
  		//$this->getUser()->setAttribute('pageU', $this->pageU);
  		
	}
	
  public function executeSubreviews()
  {
  	if (!isset($this->showCount)){
  		$this->showCount = SfReviewManager::NUM_REVIEWS;
  	}
  	/*
  	$this->reviewLastList = SfReviewManager::getLastReviewsByEntityAndValue(false, $this->type_id, $this->id, null, SfReviewManager::NUM_LAST_REVIEWS);
  	$exclude = array();
  	foreach ($this->reviewLastList->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
  	*/
  	$this->reviewList = SfReviewManager::getReviewsByEntityAndValue(false, $this->type_id, $this->id, null, $this->showCount);
  	
	//$this->positiveCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, 1);
	//$this->negativeCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, -1);
	$this->total = $this->reviewList->getNbResults();// + $this->reviewList->getNbResults();
	
	$this->seeMoreCount = 0;
	if ($this->total > $this->showCount){
		$this->seeMoreCount = ($this->total - $this->showCount)>10?($this->showCount+10):($this->total); 	
	}
	
	$this->review_c = $this->getUser()->getAttribute('review_c');
	
  }
  
  public function executeSendStmt()
  {
  	
  }
  
  public function executeQuickvote()
  {
  	$this->review = false;
  	
  	$sf_user = sfContext::getInstance()->getUser();
  	if ($sf_user->isAuthenticated()){
	  	$c = new Criteria();
	  	$c->add(SfReviewPeer::ENTITY_ID, $this->entity->getId());
	  	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $sf_user->getGuardUser()->getId());
	  	$c->add(SfReviewPeer::IS_ACTIVE, true);
	  	$c->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->entity->getType());
	  	
	  	$this->review = SfReviewPeer::doSelectOne( $c );
  	}
  }
  
}

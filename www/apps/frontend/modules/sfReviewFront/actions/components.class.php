<?php

class sfReviewFrontComponents extends sfReviewComponents
{
	public function executeActivityForList(){

	}
	
  public function executeSendStmt()
  {
  	if($this->reviewType == Politico::NUM_ENTITY){
  		$this->politico = PoliticoPeer::retrieveByPK($this->reviewEntityId);
  	}
  	else if($this->reviewType == Partido::NUM_ENTITY){
  		$this->partido = PartidoPeer::retrieveByPK($this->reviewEntityId);
  	}
  	else if($this->reviewType != null){
  		$type = SfReviewTypePeer::retrieveByPk($this->reviewType);
  		$peer = $type->getModel().'Peer';
  		$this->entity = $peer::retrieveByPK($this->reviewEntityId);
  	}
  	else if($this->reviewType == null){
  		$review_ = SfReviewPeer::retrieveByPK($this->reviewEntityId);
  		if ($review_){
  			$this->review = $review_;
		  	if($this->review->getSfReviewTypeId() == Politico::NUM_ENTITY){
		  		$this->politico = PoliticoPeer::retrieveByPK($this->review->getEntityId());
		  	}
		  	else if($this->review->getSfReviewTypeId() == Partido::NUM_ENTITY){
		  		$this->partido = PartidoPeer::retrieveByPK($this->review->getEntityId());
		  	}
		  	else {
		  		$type = SfReviewTypePeer::retrieveByPk($this->review->getSfReviewTypeId());
		  		$peer = $type->getModel().'Peer';
  				$this->entity = $peer::retrieveByPK($this->review->getEntityId());
		  	}
  		}
  	}
  }
  
	public function executeActivities(){
		$this->page = $this->page?$this->page:1;
		sfContext::getInstance()->getRequest()->setAttribute('page', $this->page);
		
		$filter = array();
		if (isset($this->sfReviewType))
			$filter['type_id'] = $this->sfReviewType;
		if (isset($this->entityId))
			$filter['entity_id'] = $this->entityId;
		if (isset($this->value))
			$filter['value'] = $this->value;
		if (isset($this->filter))
			$filter['textFilter'] = $this->filter;
		if (isset($this->userId))
			$filter['userId'] = $this->userId;
		if (isset($this->culture))
			$filter['culture'] = $this->culture;
			
		$sfr_status = sfContext::getInstance()->getRequest()->getAttribute('sfr_status', false);

		$this->count = SfReviewManager::getActivitiesCount($filter);
		$this->activities = SfReviewManager::getActivities($filter, $this->page, 20 * ($sfr_status && !$sfr_status['t']?$sfr_status['pag']:1));		
	}
}

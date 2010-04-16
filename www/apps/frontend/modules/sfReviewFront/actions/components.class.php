<?php

class sfReviewFrontComponents extends sfReviewComponents
{
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
}

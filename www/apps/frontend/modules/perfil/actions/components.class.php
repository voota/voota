<?php

class perfilComponents extends sfReviewComponents
{
  public function executeProfileReview(){
  	$type = $this->review->getSfReviewTypeId();
  	if ( $type ){
  		$peer = $this->review->getSfReviewType()->getModel() . 'Peer';
  		$this->entity = $peer::retrieveByPK($this->review->getEntityId());
  	}
  	elseif($this->review->getSfReviewRelatedBySfReviewId()) {
  		$type = $this->review->getSfReviewRelatedBySfReviewId()->getSfReviewType();
  		
  		$peer = $type->getModel() . 'Peer';
  		$this->entity = $peer::retrieveByPK($this->review->getSfReviewRelatedBySfReviewId()->getEntityId());
  	}
  	/*
  	if ( $this->review->getSfReviewType() && $this->review->getSfReviewType()->getId() == Politico::NUM_ENTITY){
  		$this->politico = PoliticoPeer::retrieveByPK($this->review->getEntityId());
  	}
  	else if ( $this->review->getSfReviewType() && $this->review->getSfReviewType()->getId() == Partido::NUM_ENTITY){
  		$this->partido = PartidoPeer::retrieveByPK($this->review->getEntityId());  		
  	}
  	else {
  		if ( $this->review->getSfReviewRelatedBySfReviewId()->getSfReviewType() && $this->review->getSfReviewRelatedBySfReviewId()->getSfReviewType()->getId() == Partido::NUM_ENTITY){
	  		$this->partido = PartidoPeer::retrieveByPK($this->review->getSfReviewRelatedBySfReviewId()->getEntityId());  		
  		}
  		else {
  			$this->politico = PoliticoPeer::retrieveByPK($this->review->getSfReviewRelatedBySfReviewId()->getEntityId());
  		}  		
  	}
  	*/
  }
}

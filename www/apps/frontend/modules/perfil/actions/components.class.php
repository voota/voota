<?php

class perfilComponents extends sfReviewComponents
{
  public function executeProfileReview(){
  	if ( $this->review->getSfReviewType() && $this->review->getSfReviewType()->getId() == 1){
  		$this->politico = PoliticoPeer::retrieveByPK($this->review->getEntityId());
  	}
  	else {
  		$this->politico = PoliticoPeer::retrieveByPK($this->review->getSfReviewRelatedBySfReviewId()->getEntityId());  		
  	}
  }
}

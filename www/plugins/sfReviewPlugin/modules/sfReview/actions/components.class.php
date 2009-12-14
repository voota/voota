<?php

class sfReviewComponents extends sfComponents
{
  public function executeReviewData()
  {
  	$reviewOri = $this->form->getObject();
  	$this->entityText = "";
  	if ($reviewOri->getSfReviewType() == null){
  		$this->entityText = "Review on ";
  		$review = $reviewOri->getSfReviewRelatedBySfReviewId();
  		$this->type = 'sfReview';
  		$this->entityId = $reviewOri->getSfReviewId();
  	}
   	else {
   		$review = $reviewOri;
  		$this->type = $reviewOri->getSfReviewType()->getModule();
  		$this->entityId = $reviewOri->getEntityId();
   	}
   	
   	
	$clazz = $review->getSfReviewType()->getModel() . 'Peer';
	$this->entity = call_user_func(array($clazz, 'retrieveByPK'), $review->getEntityId());
	$this->entityText .= $this->entity;
  }
}

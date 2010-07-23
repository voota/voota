<?php

/**
 * @author sergio
 *
 */
class Activity {
	var $id;
	var $mode;
	var $type;
	var $date;
	var $culture;
	var $text;
	var $sf_guard_user_id;
	var $sf_guard_user = false;
	var $value;
	var $entity_id;
	var $entity = false;
	var $sf_review_status_id;
	var $sf_review_status = false;
	var $sf_review_id;

	function getMode(){
		return $this->mode;
	}
	function getType(){
		return $this->type;
	}
	function getDate(){
		return $this->date;
	}
	function getCulture(){
		return $this->culture;
	}
	function getText(){
		return $this->text;
	}
	function getId(){
		return $this->id;
	}
	function getSfGuardUserId(){
		return $this->sf_guard_user_id;
	}
	function getSfGuardUser(){
		if (!$this->sf_guard_user){
			$this->sf_guard_user = sfGuardUserPeer::retrieveByPK($this->sf_guard_user_id);
		}
		return $this->sf_guard_user;
	}
	function getValue(){
		return $this->value;
	}
	function getEntityId(){
		return $this->entity_id;
	}
	function getEntity(){
		if (!$this->entity){
			if($this->getType()){
				$this->aReview = false;
				$type = SfReviewTypePeer::retrieveByPk( $this->getType() );
				$peer = $type->getModel(). 'Peer';
				$this->entity = call_user_func("$peer::retrieveByPK", $this->entity_id);
			}
			else{
				$this->aReview = SfReviewPeer::retrieveByPk($this->sf_review_id);
				//$this->aReview = $this->review->getSfReviewRelatedBySfReviewId();
				$peer = $this->aReview->getSfReviewType()->getModel(). 'Peer';
				$this->entity = call_user_func("$peer::retrieveByPk", $this->aReview->getEntityId());
			}
		}
		
		return $this->entity;
	}
	function getSfReviewStatusId(){
		return $this->sf_review_status_id;
	}
	function getSfReviewStatus(){
		if (!$this->sf_review_status){
			$this->sf_review_status = SfReviewStatusPeer::retrieveByPk($this->sf_review_status_id);
		}
		return $this->sf_review_status;
	}
}
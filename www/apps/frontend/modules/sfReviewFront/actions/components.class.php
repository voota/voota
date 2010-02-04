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
  	else if($this->reviewType == null){
  		echo ("alert('".$this->reviewId."');");
  		$this->review = SfReviewPeer::retrieveByPK($this->reviewId);
  		if ($this->review){
		  	if($this->review->getSfReviewTypeId() == Politico::NUM_ENTITY){
		  		$this->politico = PoliticoPeer::retrieveByPK($this->reviewEntityId);
		  	}
		  	else if($this->review->getSfReviewTypeId() == Partido::NUM_ENTITY){
		  		$this->partido = PartidoPeer::retrieveByPK($this->review->getEntityId());
		  	}
  		}
  	}
  }
}

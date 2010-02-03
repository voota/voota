<?php

class sfReviewFrontComponents extends sfReviewComponents
{
  public function executeSendStmt()
  {
  	if($this->reviewType == Politico::NUM_ENTITY){
  		$this->politico = PoliticoPeer::retrieveByPK($this->reviewEntityId);
  	}
  }
}

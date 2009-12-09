<?php
class sfReviewComponents extends sfComponents
{
  public function executeSubreviews()
  {
  	if (!isset($this->showCount)){
  		$this->showCount = 2;
  	}
  	$this->reviewList = SfReviewManager::getReviewsByEntityAndValue(false, '', $this->id, null, $this->showCount);
	$this->positiveCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, 1);
	$this->negativeCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, -1);
	$this->total = $this->reviewList->getNbResults();
	
	$this->seeMoreCount = 0;
	if ($this->total > $this->showCount){
		$this->seeMoreCount = ($this->total - $this->showCount)>10?($this->showCount+10):($this->total); 	
	}
	
	$this->review_c = $this->getUser()->getAttribute('review_c');
	
  }
}

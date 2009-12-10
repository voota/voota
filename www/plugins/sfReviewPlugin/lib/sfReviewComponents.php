<?php
class sfReviewComponents extends sfComponents
{
  public function executeSubreviews()
  {
  	if (!isset($this->showCount)){
  		$this->showCount = SfReviewManager::NUM_LAST_REVIEWS;
  	}
  	$this->reviewLastList = SfReviewManager::getLastReviewsByEntityAndValue(false, '', $this->id, null, SfReviewManager::NUM_LAST_REVIEWS);
  	$exclude = array();
  	foreach ($this->reviewLastList->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
  	if ($this->showCount > SfReviewManager::NUM_LAST_REVIEWS){
  		$this->reviewList = SfReviewManager::getReviewsByEntityAndValue(false, '', $this->id, null, ($this->showCount - SfReviewManager::NUM_LAST_REVIEWS), $exclude);
  	}
  	
	$this->positiveCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, 1);
	$this->negativeCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, -1);
	$this->total = $this->reviewLastList->getNbResults();// + $this->reviewList->getNbResults();
	
	$this->seeMoreCount = 0;
	if ($this->total > $this->showCount){
		$this->seeMoreCount = ($this->total - $this->showCount)>10?($this->showCount+10):($this->total); 	
	}
	
	$this->review_c = $this->getUser()->getAttribute('review_c');
	
  }
}

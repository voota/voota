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
  }
}

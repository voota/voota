<?php
class politicoComponents extends sfComponents
{
  public function executeSubreviews()
  {
  	$this->reviewList = SfReviewManager::getReviewsByEntityAndValue(false, '', $this->id);
  }
}

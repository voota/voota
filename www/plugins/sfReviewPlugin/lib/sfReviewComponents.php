<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage review
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

class sfReviewComponents extends sfComponents
{
  public function executeSubreviews()
  {
  	if (!isset($this->showCount)){
  		$this->showCount = SfReviewManager::NUM_LAST_REVIEWS;
  	}
  	$this->reviewLastList = SfReviewManager::getLastReviewsByEntityAndValue(false, $this->type_id, $this->id, null, SfReviewManager::NUM_LAST_REVIEWS);
  	$exclude = array();
  	foreach ($this->reviewLastList->getResults() as $result){
  		$exclude[] = $result->getId();
  	}
  	if ($this->showCount > SfReviewManager::NUM_LAST_REVIEWS){
  		$this->reviewList = SfReviewManager::getReviewsByEntityAndValue(false, $this->type_id, $this->id, null, ($this->showCount - SfReviewManager::NUM_LAST_REVIEWS), $exclude);
  	}
  	
	//$this->positiveCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, 1);
	//$this->negativeCount =  SfReviewManager::getTotalReviewsByEntityAndValue('', $this->id, -1);
	$this->total = $this->reviewLastList->getNbResults();// + $this->reviewList->getNbResults();
	
	$this->seeMoreCount = 0;
	if ($this->total > $this->showCount){
		$this->seeMoreCount = ($this->total - $this->showCount)>10?($this->showCount+10):($this->total); 	
	}
	
	$this->review_c = $this->getUser()->getAttribute('review_c');
	
  }
}

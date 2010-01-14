<?php

class Partido extends BasePartido
{
	const NUM_ENTITY = 2;
  public function __toString()
  {
    return $this->getAbreviatura();  // getTitle() se hereda de BaseArticle
  }

  public function getPositives() {
  	return SfReviewManager::getTotalReviewsByEntityAndValue(Partido::NUM_ENTITY, $this->getId(), 1);
  }
  
  public function getNegatives(){
  	return SfReviewManager::getTotalReviewsByEntityAndValue(Partido::NUM_ENTITY, $this->getId(), -1);
  }
}

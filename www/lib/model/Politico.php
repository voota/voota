<?php

class Politico extends BasePolitico
{
	const NUM_ENTITY = 1;
	
  public function __toString()
  {
    return $this->getNombre() . ' ' . $this->getApellidos();  // getTitle() se hereda de BaseArticle
  }
  
  public function getPositives() {
  	return SfReviewManager::getTotalReviewsByEntityAndValue(1, $this->getId(), 1);
  }
  
  public function getNegatives(){
  	return SfReviewManager::getTotalReviewsByEntityAndValue(1, $this->getId(), -1);
  }
}

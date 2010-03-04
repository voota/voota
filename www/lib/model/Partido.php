<?php

class Partido extends BasePartido implements reviewable
{
	const NUM_ENTITY = 2;
  public function __toString()
  {
    return $this->getAbreviatura();  // getTitle() se hereda de BaseArticle
  }

  public function getLongName()
  {
    return $this->__toString();
  }

  public function getPositives() {
  	return SfReviewManager::getTotalReviewsByEntityAndValue(Partido::NUM_ENTITY, $this->getId(), 1);
  }
  
  public function getNegatives(){
  	return SfReviewManager::getTotalReviewsByEntityAndValue(Partido::NUM_ENTITY, $this->getId(), -1);
  }

  
	var $sumut = 0;
	var $sumdt = 0;
	public function getSumut(){
		return $this->sumut;
	}
	public function setSumut($v){
		return $this->sumut = $v;
	}
	public function getSumdt(){
		return $this->sumdt;
	}
	public function setSumdt($v){
		return $this->sumdt = $v;
	}

	public function getTotalt(){
		return $this->sumut + $this->sumdt;
	}
	public function getVanity(){
		return $this->getAbreviatura();
	}
	public function getPath(){
		return 'partidos';
	}
	public function getModule(){
		return 'partido';
	}
	public function getImagePath(){
		return "partidos";
	}
}

<?php

class generalComponents extends sfComponents
{
	public function executeTags(){
		$this->myTags = TagManager::getTagsByLoggedUser($this->entity);
		$this->allTags = TagManager::getTags($this->entity);
	}
	
  public function executePropuestaResult(){
  	$this->quote = '';
  	
  	if (SfVoUtil::matches($this->obj->getTitulo(), $this->q)){
  		$this->quote = $this->obj->getDescripcion();
  	}
  	else if (SfVoUtil::matches($this->obj->getDescripcion(), $this->q)){
  		$this->quote = $this->obj->getDescripcion();
  	}
  	else {
  		$c = new Criteria();
  		$c->add(SfReviewPeer::ENTITY_ID, $this->obj->getId());
  		$c->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Propuesta::NUM_ENTITY);
  		$c->add(SfReviewPeer::IS_ACTIVE, true);
  		$c->add(SfReviewPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
  		$reviews = SfReviewPeer::doSelect( $c );
  		foreach($reviews as $review){
  			if (SfVoUtil::matches($review->getText(), $this->q)){
  				$this->quote = $review->getText();
  			}
  		}
  		if ($this->quote == ''){
	  		foreach($reviews as $review){
	  			if (SfVoUtil::matches($review->getText(), $this->q, true)){
	  				$this->quote = $review->getText();
	  			}
	  		}
  		}
  	}
  
  	$this->quote = SfVoUtil::highlightWords($this->quote, $this->q);
  }
  public function executePoliticoResult(){
  	$this->quote = '';
  	
  	if (SfVoUtil::matches($this->obj->getNombre(), $this->q)){
  	}
  	else if (SfVoUtil::matches($this->obj->getApellidos(), $this->q)){
  	}
  	else if (SfVoUtil::matches($this->obj->getAlias(), $this->q)){
  		$this->quote = $this->obj->getAlias();
  	}
  	else if (SfVoUtil::matches($this->obj->getBio(), $this->q)){
  		$this->quote = $this->obj->getBio();
  	}
  	else if (SfVoUtil::matches($this->obj->getPresentacion(), $this->q)){
  		$this->quote = $this->obj->getPresentacion();
  	}
  	else if (SfVoUtil::matches($this->obj->getResidencia(), $this->q)){
  		$this->quote = $this->obj->getResidencia();
  	}
  	else if (SfVoUtil::matches($this->obj->getFormacion(), $this->q)){
  		$this->quote = $this->obj->getFormacion();
  	}
  	else {
  		$c = new Criteria();
  		$c->add(SfReviewPeer::ENTITY_ID, $this->obj->getId());
  		$c->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Politico::NUM_ENTITY);
  		$c->add(SfReviewPeer::IS_ACTIVE, true);
  		$c->add(SfReviewPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
  		$reviews = SfReviewPeer::doSelect( $c );
  		foreach($reviews as $review){
  			if (SfVoUtil::matches($review->getText(), $this->q)){
  				$this->quote = $review->getText();
  			}
  		}
  		if ($this->quote == ''){
	  		foreach($reviews as $review){
	  			if (SfVoUtil::matches($review->getText(), $this->q, true)){
	  				$this->quote = $review->getText();
	  			}
	  		}
  		}
  	}
  
  	$this->quote = SfVoUtil::highlightWords($this->quote, $this->q);
  }
  
  public function executePartidoResult(){
  	$this->quote = '';
  	
  	if (SfVoUtil::matches($this->obj->getNombre(), $this->q)){
  	}
  	else if (SfVoUtil::matches($this->obj->getAbreviatura(), $this->q)){
  	}
  	else if (SfVoUtil::matches($this->obj->getPresentacion(), $this->q)){
  		$this->quote = $this->obj->getPresentacion();
  	}
  	else {
  		$c = new Criteria();
  		$c->add(SfReviewPeer::ENTITY_ID, $this->obj->getId());
  		$c->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Partido::NUM_ENTITY);
  		$c->add(SfReviewPeer::IS_ACTIVE, true);
  		$c->add(SfReviewPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
  		$reviews = SfReviewPeer::doSelect( $c );
  		foreach($reviews as $review){
  			if (SfVoUtil::matches($review->getText(), $this->q)){
  				$this->quote = $review->getText();
  			}
  		}
  		if ($this->quote == ''){
	  		foreach($reviews as $review){
	  			if (SfVoUtil::matches($review->getText(), $this->q, true)){
	  				$this->quote = $review->getText();
	  			}
	  		}
  		}
  	}
  
  	$this->quote = SfVoUtil::highlightWords($this->quote, $this->q);
  }
  
  public function executeInstitucionResult(){
  	$this->quote = '';
  	
  	if (SfVoUtil::matches($this->obj->getNombre(), $this->q)){
  	}
  
  	$this->quote = '';//SfVoUtil::highlightWords($this->quote, $this->q);
  }
  
  public function executeUsuarioResult(){
  	$this->quote = '';
  	
  	if (SfVoUtil::matches($this->obj->getProfile()->getNombre(), $this->q)){
  	}
  	else if (SfVoUtil::matches($this->obj->getProfile()->getApellidos(), $this->q)){
  	}
  	else if (SfVoUtil::matches($this->obj->getProfile()->getPresentacion(), $this->q)){
  		$this->quote = $this->obj->getProfile()->getPresentacion();
  	}
  	
  	$c = new Criteria();
  	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $this->obj->getId());
  	$c->add(SfReviewPeer::IS_ACTIVE, true);
	$this->numReviews = SfReviewPeer::doCount( $c );
	
  	$this->quote = SfVoUtil::highlightWords($this->quote, $this->q);
  }
  
  public function executeSparkline(){
	$query = "SELECT year(date) year, month(date) month, IFNULL(MAX(r.sum), 0) AS sum
				FROM sf_review_type_entity  r
				WHERE r.value = 1 
				AND r.entity_id = ? AND r.sf_review_type_id = ?
				GROUP BY year, month
				ORDER BY year, month
				";
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->bindValue(1, $this->reviewable->getId());
	$statement->bindValue(2, $this->reviewable->getType());

	$statement->execute();
	$data = $statement->fetchAll(PDO::FETCH_OBJ);
	
  	$this->sparklineData = "";
  	$last = 0;	
  	$idx = 0;
  	$firstDate = getDate(mktime (0,0,0,date("m")-7,date("d"),date("Y")));
  	$aMonth = $firstDate['mon'];
  	$aYear = $firstDate['year'];
  		
  	if (count($data) == 0){
  		$this->sparklineData = "0,0";
  	}
	foreach ($data as $element) {
		$idx++;
		if($idx == 1){
  			while ($element->year > $aYear || ($element->year == $aYear && $element->month > $aMonth)){
				$aMonth++;
				if ($aMonth == 13){
					$aMonth = 1;
					$aYear++; 
				}
				$this->sparklineData .= ($this->sparklineData?", ":'')."0";
  			}
		}
		$this->sparklineData .= ($this->sparklineData?", ":'')."" .($element->sum - $last)."";
		$last = $element->sum;
	}
  }
}

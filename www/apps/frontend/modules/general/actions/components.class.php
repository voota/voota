<?php

 
 
class generalComponents extends sfComponents
{
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
}

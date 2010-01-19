<?php

 
 
class generalComponents extends sfComponents
{
  public function executePoliticoResult(){
  	$this->quote = '';
  	
  	if (SfVoUtil::matches($this->obj->getNombre(), $this->q)){
  		$this->quote = $this->obj->getNombre();
  	}
  	else if (SfVoUtil::matches($this->obj->getApellidos(), $this->q)){
  		$this->quote = $this->obj->getApellidos();
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
  	}
  
  	$this->quote = SfVoUtil::highlightWords($this->quote, $this->q);
  }
}

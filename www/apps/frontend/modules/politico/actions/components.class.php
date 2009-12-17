<?php

class politicoComponents extends sfReviewComponents
{
  public function executeSparkline(){
    $c = new Criteria();
  	$c->add(SfReviewTypeEntityPeer::ENTITY_ID, $this->politico->getId());
  	$c->add(SfReviewTypeEntityPeer::VALUE, 1);
  	$c->addAscendingOrderByColumn(SfReviewTypeEntityPeer::DATE);
  	$elements = SfReviewTypeEntityPeer::doSelect( $c );

  	$this->sparklineData = "";		
  	$spi = 0;
	foreach ($elements as $element) {
		$this->sparklineData .= ($spi++>0?",":"").$element->getSum();
	}  	
  }
}

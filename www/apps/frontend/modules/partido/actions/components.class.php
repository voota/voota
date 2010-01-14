<?php

class partidoComponents extends sfComponents
{
  public function executeSparkline(){
  	/*
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
	*/
	$query = "select entity_id, month(date) as month, max(sum) as sum from sf_review_type_entity where value = 1 and entity_id = ? group by entity_id, month(date) order by month";
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->bindValue(1, $this->partido->getId());

	$statement->execute();
	$data = $statement->fetchAll(PDO::FETCH_OBJ);
	
  	$this->sparklineData = "0, 0";
  	$last = 0;	
	foreach ($data as $element) {
		$this->sparklineData .= ", " .($element->sum - $last);
		$last = $element->sum;
	}
	
	
	
	
	// select entity_id, month(date), value, sum from sf_review_type_entity where value = 1 group by entity_id, month(date)
	
  }
}

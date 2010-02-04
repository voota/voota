<?php

class politicoComponents extends sfComponents
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
	$query = "SELECT f.year, f.month, IFNULL(MAX(r.sum), 0) AS sum
			FROM (SELECT DISTINCT MONTH(date) AS month, YEAR(date) AS year FROM sf_review_type_entity ORDER BY year, month) f
			left JOIN sf_review_type_entity  r ON (f.year = YEAR(r.date) AND f.month = MONTH(r.date) AND r.value = 1 AND r.entity_id = ?)
			GROUP BY f.year, f.month
			ORDER BY f.year, f.month;";
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->bindValue(1, $this->politico->getId());

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

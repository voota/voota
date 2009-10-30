<?php

class sfUpdateImagesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'sfReviewStats';
    $this->briefDescription = 'Collects stats for sfReview plugin';
    $this->detailedDescription = <<<EOF
The [sfReviewStats|INFO] task does things.
Call it with:

  [php symfony sfReviewStats|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    echo "Running sfReviewStatsTask ... \n";
    
	$query = "SELECT entity_id, sf_review_type_id, value, SUM(value) sum ".
			"FROM %s ".
			"group by entity_id, sf_review_type_id, value ";
	$query = sprintf($query, SfReviewPeer::TABLE_NAME);
	
  	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	//$statement->bindValue(1, 0);
	
	$statement->execute();
	while ($row = $statement->fetch()) {
		$isNew = false;
		$yesterday = strtotime("yesterday");
		$sfReviewTypeEntity = SfReviewTypeEntityPeer::retrieveByPK($row['sf_review_type_id'], $row['entity_id'], $yesterday, $row['value']);
		if (!$sfReviewTypeEntity){
			$isNew = true;
			$sfReviewTypeEntity = new SfReviewTypeEntity();
			$sfReviewTypeEntity->setSfReviewTypeId( $row['sf_review_type_id'] );
			$sfReviewTypeEntity->setEntityId( $row['entity_id'] );
			$sfReviewTypeEntity->setValue( $row['value'] );
			$sfReviewTypeEntity->setDate( $yesterday );
			$sfReviewTypeEntity->setSum( $row['sum'] );
			SfReviewTypeEntityPeer::doInsert( $sfReviewTypeEntity );
		}
	}
  }
}
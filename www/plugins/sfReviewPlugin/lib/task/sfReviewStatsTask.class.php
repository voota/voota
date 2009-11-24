<?php

/*
 * This file is part of the symfony package.
 * (c) Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Sergio Viteri <sergio@voota.es>
 * @version    SVN: $Id: sfReviewRouting.class.php 13346 2009-09-09 12:10:17Z Sergio $
 */
class sfReviewStats extends sfBaseTask
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
    
	$query = "SELECT r.entity_id, r.sf_review_type_id, r.value, SUM(r.value) sum ".
			"FROM %s r ".
			"INNER JOIN %s s ON s.id = r.sf_review_status_id ".
			//"WHERE s.published = 1 ".
			"group by entity_id, sf_review_type_id, value ";
	$query = sprintf($query, SfReviewPeer::TABLE_NAME, SfReviewStatusPeer::TABLE_NAME);
	
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

<?php


/**
 * This class defines the structure of the 'sf_review_type' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon Apr 19 14:22:46 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfReviewPlugin.lib.model.map
 */
class SfReviewTypeTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfReviewPlugin.lib.model.map.SfReviewTypeTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('sf_review_type');
		$this->setPhpName('SfReviewType');
		$this->setClassname('SfReviewType');
		$this->setPackage('plugins.sfReviewPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 45, null);
		$this->addColumn('MODEL', 'Model', 'VARCHAR', false, 45, null);
		$this->addColumn('MODULE', 'Module', 'VARCHAR', false, 45, null);
		$this->addColumn('MAX_VALUE', 'MaxValue', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SfReview', 'SfReview', RelationMap::ONE_TO_MANY, array('id' => 'sf_review_type_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewTypeEntity', 'SfReviewTypeEntity', RelationMap::ONE_TO_MANY, array('id' => 'sf_review_type_id', ), 'RESTRICT', 'RESTRICT');
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // SfReviewTypeTableMap

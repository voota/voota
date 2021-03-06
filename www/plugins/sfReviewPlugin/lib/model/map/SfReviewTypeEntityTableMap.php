<?php


/**
 * This class defines the structure of the 'sf_review_type_entity' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Apr 29 23:44:19 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfReviewPlugin.lib.model.map
 */
class SfReviewTypeEntityTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfReviewPlugin.lib.model.map.SfReviewTypeEntityTableMap';

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
		$this->setName('sf_review_type_entity');
		$this->setPhpName('SfReviewTypeEntity');
		$this->setClassname('SfReviewTypeEntity');
		$this->setPackage('plugins.sfReviewPlugin.lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('SF_REVIEW_TYPE_ID', 'SfReviewTypeId', 'INTEGER' , 'sf_review_type', 'ID', true, 11, null);
		$this->addPrimaryKey('ENTITY_ID', 'EntityId', 'INTEGER', true, 11, null);
		$this->addPrimaryKey('DATE', 'Date', 'DATE', true, null, null);
		$this->addPrimaryKey('VALUE', 'Value', 'INTEGER', true, 11, null);
		$this->addColumn('SUM', 'Sum', 'FLOAT', true, null, 0);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SfReviewType', 'SfReviewType', RelationMap::MANY_TO_ONE, array('sf_review_type_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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

} // SfReviewTypeEntityTableMap

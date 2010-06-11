<?php


/**
 * This class defines the structure of the 'sf_review' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Jun 11 10:21:45 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfReviewPlugin.lib.model.map
 */
class SfReviewTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfReviewPlugin.lib.model.map.SfReviewTableMap';

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
		$this->setName('sf_review');
		$this->setPhpName('SfReview');
		$this->setClassname('SfReview');
		$this->setPackage('plugins.sfReviewPlugin.lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('ENTITY_ID', 'EntityId', 'INTEGER', false, 11, null);
		$this->addColumn('VALUE', 'Value', 'INTEGER', true, 11, 0);
		$this->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER', 'sf_guard_user', 'ID', true, 11, null);
		$this->addForeignKey('SF_REVIEW_TYPE_ID', 'SfReviewTypeId', 'INTEGER', 'sf_review_type', 'ID', false, 11, null);
		$this->addForeignKey('SF_REVIEW_STATUS_ID', 'SfReviewStatusId', 'INTEGER', 'sf_review_status', 'ID', true, 11, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('COOKIE', 'Cookie', 'VARCHAR', false, 45, null);
		$this->addColumn('IP_ADDRESS', 'IpAddress', 'VARCHAR', false, 45, null);
		$this->addColumn('TEXT', 'Text', 'VARCHAR', false, 420, null);
		$this->addColumn('MODIFIED_AT', 'ModifiedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CULTURE', 'Culture', 'VARCHAR', false, 5, null);
		$this->addForeignKey('SF_REVIEW_ID', 'SfReviewId', 'INTEGER', 'sf_review', 'ID', false, 11, null);
		$this->addColumn('BALANCE', 'Balance', 'INTEGER', false, 11, 0);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', true, null, true);
		$this->addColumn('TO_FB', 'ToFb', 'BOOLEAN', true, null, false);
		$this->addColumn('SOURCE', 'Source', 'VARCHAR', false, 64, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('sf_guard_user_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewType', 'SfReviewType', RelationMap::MANY_TO_ONE, array('sf_review_type_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewStatus', 'SfReviewStatus', RelationMap::MANY_TO_ONE, array('sf_review_status_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewRelatedBySfReviewId', 'SfReview', RelationMap::MANY_TO_ONE, array('sf_review_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewRelatedBySfReviewId', 'SfReview', RelationMap::ONE_TO_MANY, array('id' => 'sf_review_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewAttach', 'SfReviewAttach', RelationMap::ONE_TO_MANY, array('id' => 'sf_review_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReviewModeration', 'SfReviewModeration', RelationMap::ONE_TO_MANY, array('id' => 'sf_review_id', ), 'RESTRICT', 'RESTRICT');
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
			'symfony_timestampable' => array('create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // SfReviewTableMap

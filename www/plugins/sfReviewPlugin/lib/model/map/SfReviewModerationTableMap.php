<?php


/**
 * This class defines the structure of the 'sf_review_moderation' table.
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
class SfReviewModerationTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfReviewPlugin.lib.model.map.SfReviewModerationTableMap';

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
		$this->setName('sf_review_moderation');
		$this->setPhpName('SfReviewModeration');
		$this->setClassname('SfReviewModeration');
		$this->setPackage('plugins.sfReviewPlugin.lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('CHANGED', 'Changed', 'TIMESTAMP', false, null, null);
		$this->addColumn('PREV_STATUS', 'PrevStatus', 'INTEGER', false, 11, null);
		$this->addForeignKey('REASON_ID', 'ReasonId', 'INTEGER', 'sf_review_reason', 'ID', false, 11, null);
		$this->addForeignKey('SF_REVIEW_ID', 'SfReviewId', 'INTEGER', 'sf_review', 'ID', false, 11, null);
		$this->addColumn('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('SfReviewReason', 'SfReviewReason', RelationMap::MANY_TO_ONE, array('reason_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('SfReview', 'SfReview', RelationMap::MANY_TO_ONE, array('sf_review_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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

} // SfReviewModerationTableMap

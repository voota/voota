<?php


/**
 * This class adds structure of 'sf_review_type_entity' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Fri Sep 18 11:49:08 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfReviewPlugin.lib.model.map
 */
class SfReviewTypeEntityMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfReviewPlugin.lib.model.map.SfReviewTypeEntityMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(SfReviewTypeEntityPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SfReviewTypeEntityPeer::TABLE_NAME);
		$tMap->setPhpName('SfReviewTypeEntity');
		$tMap->setClassname('SfReviewTypeEntity');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('SF_REVIEW_TYPE_ID', 'SfReviewTypeId', 'INTEGER' , 'sf_review_type', 'ID', true, 11);

		$tMap->addPrimaryKey('ENTITY_ID', 'EntityId', 'INTEGER', true, 11);

		$tMap->addPrimaryKey('DATE', 'Date', 'DATE', true, null);

		$tMap->addColumn('SUM', 'Sum', 'FLOAT', true, null);

		$tMap->addColumn('SCORE', 'Score', 'FLOAT', true, null);

	} // doBuild()

} // SfReviewTypeEntityMapBuilder
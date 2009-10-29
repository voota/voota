<?php


/**
 * This class adds structure of 'sf_review_moderation' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Oct 29 08:39:18 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    plugins.sfReviewPlugin.lib.model.map
 */
class SfReviewModerationMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'plugins.sfReviewPlugin.lib.model.map.SfReviewModerationMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(SfReviewModerationPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SfReviewModerationPeer::TABLE_NAME);
		$tMap->setPhpName('SfReviewModeration');
		$tMap->setClassname('SfReviewModeration');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('CHANGED', 'Changed', 'TIMESTAMP', false, null);

		$tMap->addColumn('PREV_STATUS', 'PrevStatus', 'INTEGER', false, 11);

		$tMap->addForeignKey('REASON_ID', 'ReasonId', 'INTEGER', 'sf_review_reason', 'ID', false, 11);

		$tMap->addForeignKey('SF_REVIEW_ID', 'SfReviewId', 'INTEGER', 'sf_review', 'ID', false, 11);

		$tMap->addColumn('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER', false, 11);

	} // doBuild()

} // SfReviewModerationMapBuilder

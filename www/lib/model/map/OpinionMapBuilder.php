<?php


/**
 * This class adds structure of 'opinion' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Tue Sep  8 16:25:03 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class OpinionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.OpinionMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(OpinionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(OpinionPeer::TABLE_NAME);
		$tMap->setPhpName('Opinion');
		$tMap->setClassname('Opinion');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('VALOR', 'Valor', 'INTEGER', false, 11);

		$tMap->addColumn('TEXTO', 'Texto', 'VARCHAR', false, 500);

		$tMap->addForeignKey('SF_GUARD_USER_PROFILE_ID', 'SfGuardUserProfileId', 'INTEGER', 'sf_guard_user_profile', 'ID', true, 11);

		$tMap->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11);

		$tMap->addForeignKey('POLITICO_ID', 'PoliticoId', 'INTEGER', 'politico', 'ID', false, 11);

		$tMap->addForeignKey('OPINION_ID', 'OpinionId', 'INTEGER', 'opinion', 'ID', false, 11);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // OpinionMapBuilder

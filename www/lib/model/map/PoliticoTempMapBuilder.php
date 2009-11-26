<?php


/**
 * This class adds structure of 'politico_temp' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Nov 26 13:31:37 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PoliticoTempMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PoliticoTempMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PoliticoTempPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PoliticoTempPeer::TABLE_NAME);
		$tMap->setPhpName('PoliticoTemp');
		$tMap->setClassname('PoliticoTemp');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', false, 50);

		$tMap->addColumn('PARTIDO', 'Partido', 'VARCHAR', false, 50);

		$tMap->addColumn('NOMBRE', 'Nombre', 'VARCHAR', false, 50);

		$tMap->addColumn('APELLIDOS', 'Apellidos', 'VARCHAR', false, 100);

		$tMap->addColumn('BIO', 'Bio', 'CLOB', false, null);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

	} // doBuild()

} // PoliticoTempMapBuilder

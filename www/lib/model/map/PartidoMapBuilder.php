<?php


/**
 * This class adds structure of 'partido' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Fri Jan 15 11:37:36 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PartidoMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PartidoMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PartidoPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PartidoPeer::TABLE_NAME);
		$tMap->setPhpName('Partido');
		$tMap->setClassname('Partido');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('ABREVIATURA', 'Abreviatura', 'VARCHAR', false, 8);

		$tMap->addColumn('COLOR', 'Color', 'VARCHAR', false, 8);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11);

		$tMap->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50);

		$tMap->addColumn('SUMU', 'Sumu', 'INTEGER', true, 11);

		$tMap->addColumn('SUMD', 'Sumd', 'INTEGER', true, 11);

		$tMap->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', true, null);

	} // doBuild()

} // PartidoMapBuilder

<?php


/**
 * This class adds structure of 'enlace' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Sat Aug 15 18:10:54 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EnlaceMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EnlaceMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(EnlacePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(EnlacePeer::TABLE_NAME);
		$tMap->setPhpName('Enlace');
		$tMap->setClassname('Enlace');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', true, 150);

		$tMap->addColumn('TIPO', 'Tipo', 'INTEGER', false, 11);

		$tMap->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11);

		$tMap->addForeignKey('POLITICO_ID', 'PoliticoId', 'INTEGER', 'politico', 'ID', false, 11);

		$tMap->addColumn('ORDEN', 'Orden', 'INTEGER', false, 11);

		$tMap->addColumn('MOSTRAR', 'Mostrar', 'CHAR', false, 1);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // EnlaceMapBuilder

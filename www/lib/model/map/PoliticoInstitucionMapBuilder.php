<?php


/**
 * This class adds structure of 'politico_institucion' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Thu Jan 14 10:35:29 2010
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PoliticoInstitucionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PoliticoInstitucionMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PoliticoInstitucionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PoliticoInstitucionPeer::TABLE_NAME);
		$tMap->setPhpName('PoliticoInstitucion');
		$tMap->setClassname('PoliticoInstitucion');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('POLITICO_ID', 'PoliticoId', 'INTEGER' , 'politico', 'ID', true, 11);

		$tMap->addForeignPrimaryKey('INSTITUCION_ID', 'InstitucionId', 'INTEGER' , 'institucion', 'ID', true, 11);

		$tMap->addColumn('FECHA_INICIO', 'FechaInicio', 'DATE', false, null);

		$tMap->addColumn('FECHA_FIN', 'FechaFin', 'DATE', false, null);

	} // doBuild()

} // PoliticoInstitucionMapBuilder

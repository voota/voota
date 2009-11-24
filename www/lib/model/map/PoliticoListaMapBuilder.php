<?php


/**
 * This class adds structure of 'politico_lista' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Wed Nov 11 19:51:14 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PoliticoListaMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PoliticoListaMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PoliticoListaPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PoliticoListaPeer::TABLE_NAME);
		$tMap->setPhpName('PoliticoLista');
		$tMap->setClassname('PoliticoLista');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('POLITICO_ID', 'PoliticoId', 'INTEGER' , 'politico', 'ID', true, 11);

		$tMap->addForeignPrimaryKey('LISTA_ID', 'ListaId', 'INTEGER' , 'lista', 'ID', true, 11);

		$tMap->addColumn('ORDEN', 'Orden', 'INTEGER', false, 11);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PoliticoListaMapBuilder

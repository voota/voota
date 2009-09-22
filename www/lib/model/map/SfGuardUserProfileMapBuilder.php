<?php


/**
 * This class adds structure of 'sf_guard_user_profile' table to 'propel' DatabaseMap object.
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
 * @package    lib.model.map
 */
class SfGuardUserProfileMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.SfGuardUserProfileMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(SfGuardUserProfilePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SfGuardUserProfilePeer::TABLE_NAME);
		$tMap->setPhpName('SfGuardUserProfile');
		$tMap->setClassname('SfGuardUserProfile');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user', 'ID', true, 11);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', true, 150);

		$tMap->addColumn('CLAVE', 'Clave', 'VARCHAR', true, 45);

		$tMap->addColumn('ACEPTA_MENSAJES', 'AceptaMensajes', 'CHAR', false, 1);

		$tMap->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 45);

		$tMap->addColumn('APELLIDOS', 'Apellidos', 'VARCHAR', false, 150);

		$tMap->addColumn('FECHA_NACIMIENTO', 'FechaNacimiento', 'DATE', false, null);

		$tMap->addColumn('PAIS', 'Pais', 'VARCHAR', false, 45);

		$tMap->addColumn('FORMACION', 'Formacion', 'VARCHAR', false, 255);

		$tMap->addColumn('RESIDENCIA', 'Residencia', 'VARCHAR', false, 45);

		$tMap->addColumn('PRESENTACION', 'Presentacion', 'VARCHAR', false, 500);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // SfGuardUserProfileMapBuilder

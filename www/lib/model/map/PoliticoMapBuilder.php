<?php


/**
 * This class adds structure of 'politico' table to 'propel' DatabaseMap object.
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
class PoliticoMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PoliticoMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PoliticoPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PoliticoPeer::TABLE_NAME);
		$tMap->setPhpName('Politico');
		$tMap->setClassname('Politico');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11);

		$tMap->addColumn('URL_KEY', 'UrlKey', 'VARCHAR', true, 45);

		$tMap->addColumn('ALIAS', 'Alias', 'VARCHAR', false, 45);

		$tMap->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 45);

		$tMap->addColumn('APELLIDOS', 'Apellidos', 'VARCHAR', true, 150);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', false, 45);

		$tMap->addColumn('SEXO', 'Sexo', 'CHAR', false, 1);

		$tMap->addColumn('FECHA_NACIMIENTO', 'FechaNacimiento', 'DATE', false, null);

		$tMap->addColumn('PAIS', 'Pais', 'VARCHAR', false, 45);

		$tMap->addColumn('FORMACION', 'Formacion', 'VARCHAR', false, 255);

		$tMap->addColumn('RESIDENCIA', 'Residencia', 'VARCHAR', false, 45);

		$tMap->addColumn('PRESENTACION', 'Presentacion', 'VARCHAR', false, 500);

		$tMap->addForeignKey('SF_GUARD_USER_PROFILE_ID', 'SfGuardUserProfileId', 'INTEGER', 'sf_guard_user_profile', 'ID', false, 11);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11);

		$tMap->addColumn('PARTIDO_TXT', 'PartidoTxt', 'VARCHAR', false, 150);

		$tMap->addColumn('BIO', 'Bio', 'CLOB', false, null);

		$tMap->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50);

		$tMap->addColumn('VANITY', 'Vanity', 'VARCHAR', false, 45);

		$tMap->addColumn('LUGAR_NACIMIENTO', 'LugarNacimiento', 'VARCHAR', false, 150);

		$tMap->addColumn('SUMU', 'Sumu', 'INTEGER', true, 11);

		$tMap->addColumn('SUMD', 'Sumd', 'INTEGER', true, 11);

		$tMap->addColumn('RELACION', 'Relacion', 'CHAR', false, 2);

		$tMap->addColumn('HIJOS', 'Hijos', 'INTEGER', false, 11);

		$tMap->addColumn('HIJAS', 'Hijas', 'INTEGER', false, 11);

	} // doBuild()

} // PoliticoMapBuilder

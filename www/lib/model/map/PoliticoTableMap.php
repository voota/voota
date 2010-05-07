<?php


/**
 * This class defines the structure of the 'politico' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri May  7 14:15:14 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PoliticoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PoliticoTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('politico');
		$this->setPhpName('Politico');
		$this->setClassname('Politico');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('ALIAS', 'Alias', 'VARCHAR', false, 45, null);
		$this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 45, null);
		$this->addColumn('APELLIDOS', 'Apellidos', 'VARCHAR', true, 150, null);
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 128, null);
		$this->addColumn('SEXO', 'Sexo', 'CHAR', false, 1, null);
		$this->addColumn('FECHA_NACIMIENTO', 'FechaNacimiento', 'DATE', false, null, null);
		$this->addColumn('PAIS', 'Pais', 'VARCHAR', false, 45, null);
		$this->addColumn('RESIDENCIA', 'Residencia', 'VARCHAR', false, 45, null);
		$this->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER', 'sf_guard_user', 'ID', false, 11, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('MODIFIED_AT', 'ModifiedAt', 'TIMESTAMP', false, null, null);
		$this->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11, null);
		$this->addColumn('PARTIDO_TXT', 'PartidoTxt', 'VARCHAR', false, 150, null);
		$this->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50, null);
		$this->addColumn('VANITY', 'Vanity', 'VARCHAR', false, 45, null);
		$this->addColumn('LUGAR_NACIMIENTO', 'LugarNacimiento', 'VARCHAR', false, 150, null);
		$this->addColumn('SUMU', 'Sumu', 'INTEGER', true, 11, 0);
		$this->addColumn('SUMD', 'Sumd', 'INTEGER', true, 11, 0);
		$this->addColumn('RELACION', 'Relacion', 'CHAR', false, 2, null);
		$this->addColumn('HIJOS', 'Hijos', 'INTEGER', false, 11, null);
		$this->addColumn('HIJAS', 'Hijas', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('sf_guard_user_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Partido', 'Partido', RelationMap::MANY_TO_ONE, array('partido_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Enlace', 'Enlace', RelationMap::ONE_TO_MANY, array('id' => 'politico_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Imagen', 'Imagen', RelationMap::ONE_TO_MANY, array('id' => 'politico_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PoliticoI18n', 'PoliticoI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PoliticoInstitucion', 'PoliticoInstitucion', RelationMap::ONE_TO_MANY, array('id' => 'politico_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PoliticoLista', 'PoliticoLista', RelationMap::ONE_TO_MANY, array('id' => 'politico_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Promocion', 'Promocion', RelationMap::ONE_TO_MANY, array('id' => 'politico_id', ), 'RESTRICT', 'RESTRICT');
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', ),
			'symfony_i18n' => array('i18n_table' => 'politico_i18n', ),
		);
	} // getBehaviors()

} // PoliticoTableMap

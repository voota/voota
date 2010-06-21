<?php


/**
 * This class defines the structure of the 'institucion' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon Jun 21 15:30:01 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class InstitucionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.InstitucionTableMap';

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
		$this->setName('institucion');
		$this->setPhpName('Institucion');
		$this->setClassname('Institucion');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addForeignKey('GEO_ID', 'GeoId', 'INTEGER', 'geo', 'ID', false, 11, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('DISABLED', 'Disabled', 'CHAR', false, 1, null);
		$this->addColumn('ORDEN', 'Orden', 'INTEGER', false, 11, null);
		$this->addColumn('URL', 'Url', 'VARCHAR', false, 255, null);
		$this->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50, null);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', true, null, true);
		$this->addColumn('IS_MAIN', 'IsMain', 'BOOLEAN', true, null, true);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Geo', 'Geo', RelationMap::MANY_TO_ONE, array('geo_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('EleccionInstitucion', 'EleccionInstitucion', RelationMap::ONE_TO_MANY, array('id' => 'institucion_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('InstitucionI18n', 'InstitucionI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PoliticoInstitucion', 'PoliticoInstitucion', RelationMap::ONE_TO_MANY, array('id' => 'institucion_id', ), 'RESTRICT', 'RESTRICT');
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
			'symfony_i18n' => array('i18n_table' => 'institucion_i18n', ),
		);
	} // getBehaviors()

} // InstitucionTableMap

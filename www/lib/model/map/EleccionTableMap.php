<?php


/**
 * This class defines the structure of the 'eleccion' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue Jul 27 09:01:31 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EleccionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EleccionTableMap';

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
		$this->setName('eleccion');
		$this->setPhpName('Eleccion');
		$this->setClassname('Eleccion');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('VANITY', 'Vanity', 'VARCHAR', true, 150, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('EleccionI18n', 'EleccionI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Convocatoria', 'Convocatoria', RelationMap::ONE_TO_MANY, array('id' => 'eleccion_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('EleccionInstitucion', 'EleccionInstitucion', RelationMap::ONE_TO_MANY, array('id' => 'eleccion_id', ), 'RESTRICT', 'RESTRICT');
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
			'symfony_i18n' => array('i18n_table' => 'eleccion_i18n', ),
		);
	} // getBehaviors()

} // EleccionTableMap

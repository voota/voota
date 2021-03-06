<?php


/**
 * This class defines the structure of the 'politico_institucion' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Apr 29 23:44:17 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PoliticoInstitucionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PoliticoInstitucionTableMap';

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
		$this->setName('politico_institucion');
		$this->setPhpName('PoliticoInstitucion');
		$this->setClassname('PoliticoInstitucion');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('POLITICO_ID', 'PoliticoId', 'INTEGER' , 'politico', 'ID', true, 11, null);
		$this->addForeignPrimaryKey('INSTITUCION_ID', 'InstitucionId', 'INTEGER' , 'institucion', 'ID', true, 11, null);
		$this->addColumn('FECHA_INICIO', 'FechaInicio', 'DATE', false, null, null);
		$this->addColumn('FECHA_FIN', 'FechaFin', 'DATE', false, null, null);
		$this->addColumn('CARGO', 'Cargo', 'VARCHAR', false, 2, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Politico', 'Politico', RelationMap::MANY_TO_ONE, array('politico_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Institucion', 'Institucion', RelationMap::MANY_TO_ONE, array('institucion_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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
		);
	} // getBehaviors()

} // PoliticoInstitucionTableMap

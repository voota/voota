<?php


/**
 * This class defines the structure of the 'geo' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May  4 21:02:28 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class GeoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.GeoTableMap';

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
		$this->setName('geo');
		$this->setPhpName('Geo');
		$this->setClassname('Geo');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 150, null);
		$this->addForeignKey('GEO_ID', 'GeoId', 'INTEGER', 'geo', 'ID', false, 11, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('GeoRelatedByGeoId', 'Geo', RelationMap::MANY_TO_ONE, array('geo_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('GeoRelatedByGeoId', 'Geo', RelationMap::ONE_TO_MANY, array('id' => 'geo_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Institucion', 'Institucion', RelationMap::ONE_TO_MANY, array('id' => 'geo_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Lista', 'Lista', RelationMap::ONE_TO_MANY, array('id' => 'geo_id', ), 'RESTRICT', 'RESTRICT');
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
		);
	} // getBehaviors()

} // GeoTableMap

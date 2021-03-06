<?php


/**
 * This class defines the structure of the 'convocatoria' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Apr 29 23:44:15 2011
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ConvocatoriaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ConvocatoriaTableMap';

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
		$this->setName('convocatoria');
		$this->setPhpName('Convocatoria');
		$this->setClassname('Convocatoria');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addForeignKey('ELECCION_ID', 'EleccionId', 'INTEGER', 'eleccion', 'ID', true, 11, null);
		$this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 45, null);
		$this->addColumn('FECHA', 'Fecha', 'DATE', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50, null);
		$this->addColumn('CLOSED_AT', 'ClosedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('TOTAL_ESCANYOS', 'TotalEscanyos', 'INTEGER', false, 11, null);
		$this->addColumn('MIN_SUMU', 'MinSumu', 'INTEGER', false, 11, null);
		$this->addColumn('MIN_SUMD', 'MinSumd', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Eleccion', 'Eleccion', RelationMap::MANY_TO_ONE, array('eleccion_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('ConvocatoriaI18n', 'ConvocatoriaI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Enlace', 'Enlace', RelationMap::ONE_TO_MANY, array('id' => 'convocatoria_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Lista', 'Lista', RelationMap::ONE_TO_MANY, array('id' => 'convocatoria_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('ListaCalle', 'ListaCalle', RelationMap::ONE_TO_MANY, array('id' => 'convocatoria_id', ), 'RESTRICT', 'RESTRICT');
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
			'symfony_i18n' => array('i18n_table' => 'convocatoria_i18n', ),
		);
	} // getBehaviors()

} // ConvocatoriaTableMap

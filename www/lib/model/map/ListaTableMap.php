<?php


/**
 * This class defines the structure of the 'lista' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Wed Jan 27 16:53:50 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ListaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ListaTableMap';

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
		$this->setName('lista');
		$this->setPhpName('Lista');
		$this->setClassname('Lista');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', true, 11, null);
		$this->addForeignKey('ELECCION_ID', 'EleccionId', 'INTEGER', 'eleccion', 'ID', true, 11, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Partido', 'Partido', RelationMap::MANY_TO_ONE, array('partido_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Eleccion', 'Eleccion', RelationMap::MANY_TO_ONE, array('eleccion_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PartidoLista', 'PartidoLista', RelationMap::ONE_TO_MANY, array('id' => 'lista_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PoliticoLista', 'PoliticoLista', RelationMap::ONE_TO_MANY, array('id' => 'lista_id', ), 'RESTRICT', 'RESTRICT');
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

} // ListaTableMap

<?php


/**
 * This class defines the structure of the 'etiqueta' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue Sep 28 14:48:36 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EtiquetaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EtiquetaTableMap';

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
		$this->setName('etiqueta');
		$this->setPhpName('Etiqueta');
		$this->setClassname('Etiqueta');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('TEXTO', 'Texto', 'VARCHAR', false, 45, null);
		$this->addPrimaryKey('CULTURE', 'Culture', 'VARCHAR', true, 5, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('EtiquetaPolitico', 'EtiquetaPolitico', RelationMap::ONE_TO_MANY, array('id' => 'etiqueta_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('EtiquetaPartido', 'EtiquetaPartido', RelationMap::ONE_TO_MANY, array('id' => 'etiqueta_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('EtiquetaPropuesta', 'EtiquetaPropuesta', RelationMap::ONE_TO_MANY, array('id' => 'etiqueta_id', ), 'RESTRICT', 'RESTRICT');
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

} // EtiquetaTableMap

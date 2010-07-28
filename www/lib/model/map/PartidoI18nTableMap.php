<?php


/**
 * This class defines the structure of the 'partido_i18n' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue Jul 27 12:19:19 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PartidoI18nTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PartidoI18nTableMap';

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
		$this->setName('partido_i18n');
		$this->setPhpName('PartidoI18n');
		$this->setClassname('PartidoI18n');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'partido', 'ID', true, 11, null);
		$this->addPrimaryKey('CULTURE', 'Culture', 'VARCHAR', true, 7, null);
		$this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 150, null);
		$this->addColumn('PRESENTACION', 'Presentacion', 'VARCHAR', true, 600, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Partido', 'Partido', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'RESTRICT', 'RESTRICT');
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
			'symfony_i18n_translation' => array('culture_column' => 'culture', ),
		);
	} // getBehaviors()

} // PartidoI18nTableMap

<?php


/**
 * This class defines the structure of the 'partido' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Mon Feb  1 22:14:12 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PartidoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PartidoTableMap';

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
		$this->setName('partido');
		$this->setPhpName('Partido');
		$this->setClassname('Partido');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('ABREVIATURA', 'Abreviatura', 'VARCHAR', false, 8, null);
		$this->addColumn('COLOR', 'Color', 'VARCHAR', false, 8, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11, null);
		$this->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50, null);
		$this->addColumn('SUMU', 'Sumu', 'INTEGER', true, 11, 0);
		$this->addColumn('SUMD', 'Sumd', 'INTEGER', true, 11, 0);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', true, null, true);
		$this->addColumn('IS_MAIN', 'IsMain', 'BOOLEAN', true, null, true);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PartidoRelatedByPartidoId', 'Partido', RelationMap::MANY_TO_ONE, array('partido_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Enlace', 'Enlace', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Imagen', 'Imagen', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Lista', 'Lista', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PartidoRelatedByPartidoId', 'Partido', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PartidoI18n', 'PartidoI18n', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PartidoLista', 'PartidoLista', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Politico', 'Politico', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Promocion', 'Promocion', RelationMap::ONE_TO_MANY, array('id' => 'partido_id', ), 'RESTRICT', 'RESTRICT');
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
			'symfony_i18n' => array('i18n_table' => 'partido_i18n', ),
		);
	} // getBehaviors()

} // PartidoTableMap

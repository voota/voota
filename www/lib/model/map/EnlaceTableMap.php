<?php


/**
 * This class defines the structure of the 'enlace' table.
 *
 *
 * This class was autogenerated by Propel 1.4.0 on:
 *
 * Mon Jan 18 13:55:35 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EnlaceTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EnlaceTableMap';

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
		$this->setName('enlace');
		$this->setPhpName('Enlace');
		$this->setClassname('Enlace');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('URL', 'Url', 'VARCHAR', true, 150, null);
		$this->addColumn('TIPO', 'Tipo', 'INTEGER', false, 11, null);
		$this->addForeignKey('PARTIDO_ID', 'PartidoId', 'INTEGER', 'partido', 'ID', false, 11, null);
		$this->addForeignKey('POLITICO_ID', 'PoliticoId', 'INTEGER', 'politico', 'ID', false, 11, null);
		$this->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER', 'sf_guard_user', 'ID', false, 11, null);
		$this->addColumn('ORDEN', 'Orden', 'INTEGER', false, 11, null);
		$this->addColumn('MOSTRAR', 'Mostrar', 'CHAR', false, 1, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CULTURE', 'Culture', 'VARCHAR', false, 7, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Partido', 'Partido', RelationMap::MANY_TO_ONE, array('partido_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Politico', 'Politico', RelationMap::MANY_TO_ONE, array('politico_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('sf_guard_user_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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

} // EnlaceTableMap
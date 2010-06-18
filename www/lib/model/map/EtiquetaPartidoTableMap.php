<?php


/**
 * This class defines the structure of the 'etiqueta_partido' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Fri Jun 18 12:12:04 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EtiquetaPartidoTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EtiquetaPartidoTableMap';

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
		$this->setName('etiqueta_partido');
		$this->setPhpName('EtiquetaPartido');
		$this->setClassname('EtiquetaPartido');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ETIQUETA_ID', 'EtiquetaId', 'INTEGER' , 'etiqueta', 'ID', true, 11, null);
		$this->addForeignPrimaryKey('PARTIDO_ID', 'PartidoId', 'INTEGER' , 'partido', 'ID', true, 11, null);
		$this->addForeignPrimaryKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER' , 'sf_guard_user', 'ID', true, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Etiqueta', 'Etiqueta', RelationMap::MANY_TO_ONE, array('etiqueta_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Partido', 'Partido', RelationMap::MANY_TO_ONE, array('partido_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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
		);
	} // getBehaviors()

} // EtiquetaPartidoTableMap

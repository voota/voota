<?php


/**
 * This class defines the structure of the 'propuesta' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Wed Jul 21 10:28:33 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PropuestaTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PropuestaTableMap';

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
		$this->setName('propuesta');
		$this->setPhpName('Propuesta');
		$this->setClassname('Propuesta');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addColumn('TITULO', 'Titulo', 'VARCHAR', false, 150, null);
		$this->addColumn('DESCRIPCION', 'Descripcion', 'VARCHAR', false, 600, null);
		$this->addColumn('CULTURE', 'Culture', 'VARCHAR', false, 7, null);
		$this->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50, null);
		$this->addColumn('DOC', 'Doc', 'VARCHAR', false, 50, null);
		$this->addColumn('DOC_SIZE', 'DocSize', 'INTEGER', false, 50, null);
		$this->addForeignKey('SF_GUARD_USER_ID', 'SfGuardUserId', 'INTEGER', 'sf_guard_user', 'ID', true, 11, null);
		$this->addColumn('SUMU', 'Sumu', 'INTEGER', true, 11, 0);
		$this->addColumn('SUMD', 'Sumd', 'INTEGER', true, 11, 0);
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', true, null, true);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('MODIFIED_AT', 'ModifiedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('VANITY', 'Vanity', 'VARCHAR', true, 150, null);
		$this->addColumn('URL_VIDEO_1', 'UrlVideo1', 'VARCHAR', false, 150, null);
		$this->addForeignKey('PARTIDO_VIDEO1_ID', 'PartidoVideo1Id', 'INTEGER', 'partido', 'ID', false, 11, null);
		$this->addColumn('URL_VIDEO_2', 'UrlVideo2', 'VARCHAR', false, 150, null);
		$this->addForeignKey('PARTIDO_VIDEO2_ID', 'PartidoVideo2Id', 'INTEGER', 'partido', 'ID', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('sf_guard_user_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PartidoRelatedByPartidoVideo1Id', 'Partido', RelationMap::MANY_TO_ONE, array('partido_video1_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('PartidoRelatedByPartidoVideo2Id', 'Partido', RelationMap::MANY_TO_ONE, array('partido_video2_id' => 'id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('Enlace', 'Enlace', RelationMap::ONE_TO_MANY, array('id' => 'propuesta_id', ), 'RESTRICT', 'RESTRICT');
    $this->addRelation('EtiquetaPropuesta', 'EtiquetaPropuesta', RelationMap::ONE_TO_MANY, array('id' => 'propuesta_id', ), 'RESTRICT', 'RESTRICT');
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

} // PropuestaTableMap

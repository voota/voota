<?php


/**
 * This class defines the structure of the 'sf_guard_user_profile' table.
 *
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May  4 22:48:28 2010
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class SfGuardUserProfileTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.SfGuardUserProfileTableMap';

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
		$this->setName('sf_guard_user_profile');
		$this->setPhpName('SfGuardUserProfile');
		$this->setClassname('SfGuardUserProfile');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'sf_guard_user', 'ID', true, 11, null);
		$this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 45, null);
		$this->addColumn('APELLIDOS', 'Apellidos', 'VARCHAR', false, 150, null);
		$this->addColumn('FECHA_NACIMIENTO', 'FechaNacimiento', 'DATE', false, null, null);
		$this->addColumn('PAIS', 'Pais', 'VARCHAR', false, 45, null);
		$this->addColumn('FORMACION', 'Formacion', 'VARCHAR', false, 255, null);
		$this->addColumn('RESIDENCIA', 'Residencia', 'VARCHAR', false, 45, null);
		$this->addColumn('PRESENTACION', 'Presentacion', 'VARCHAR', false, 600, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('VANITY', 'Vanity', 'VARCHAR', false, 45, null);
		$this->addColumn('IMAGEN', 'Imagen', 'VARCHAR', false, 50, null);
		$this->addColumn('CODIGO', 'Codigo', 'VARCHAR', false, 45, null);
		$this->addColumn('PAPEL_VOOTA', 'PapelVoota', 'VARCHAR', false, 280, null);
		$this->addColumn('MAILS_COMENTARIOS', 'MailsComentarios', 'INTEGER', true, 11, 1);
		$this->addColumn('MAILS_NOTICIAS', 'MailsNoticias', 'INTEGER', true, 11, 1);
		$this->addColumn('MAILS_CONTACTO', 'MailsContacto', 'INTEGER', true, 11, 1);
		$this->addColumn('MAILS_SEGUIDOR', 'MailsSeguidor', 'INTEGER', true, 11, 1);
		$this->addColumn('NUMERO_SOCIO', 'NumeroSocio', 'VARCHAR', false, 45, null);
		$this->addColumn('FACEBOOK_UID', 'FacebookUid', 'VARCHAR', false, 128, '1');
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255, null);
		$this->addColumn('EMAIL_HASH', 'EmailHash', 'VARCHAR', false, 255, null);
		$this->addColumn('FB_PUBLISH_VOTOS', 'FbPublishVotos', 'BOOLEAN', true, null, true);
		$this->addColumn('FB_PUBLISH_VOTOS_OTROS', 'FbPublishVotosOtros', 'BOOLEAN', true, null, true);
		$this->addColumn('FB_PUBLISH_CAMBIOS_PERFIL', 'FbPublishCambiosPerfil', 'BOOLEAN', true, null, true);
		$this->addColumn('FB_TIP', 'FbTip', 'BOOLEAN', true, null, true);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('sfGuardUser', 'sfGuardUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'RESTRICT', 'RESTRICT');
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

} // SfGuardUserProfileTableMap

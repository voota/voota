<?php

/**
 * sfGuardUser form base class.
 *
 * @method sfGuardUser getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasesfGuardUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'username'                      => new sfWidgetFormInputText(),
      'algorithm'                     => new sfWidgetFormInputText(),
      'salt'                          => new sfWidgetFormInputText(),
      'password'                      => new sfWidgetFormInputText(),
      'created_at'                    => new sfWidgetFormDateTime(),
      'last_login'                    => new sfWidgetFormDateTime(),
      'is_active'                     => new sfWidgetFormInputCheckbox(),
      'is_super_admin'                => new sfWidgetFormInputCheckbox(),
      'sf_guard_user_permission_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
      'sf_guard_user_group_list'      => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'etiqueta_politico_list'        => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Etiqueta')),
      'etiqueta_partido_list'         => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Etiqueta')),
      'etiqueta_propuesta_list'       => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Etiqueta')),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'username'                      => new sfValidatorString(array('max_length' => 128)),
      'algorithm'                     => new sfValidatorString(array('max_length' => 128)),
      'salt'                          => new sfValidatorString(array('max_length' => 128)),
      'password'                      => new sfValidatorString(array('max_length' => 128)),
      'created_at'                    => new sfValidatorDateTime(array('required' => false)),
      'last_login'                    => new sfValidatorDateTime(array('required' => false)),
      'is_active'                     => new sfValidatorBoolean(),
      'is_super_admin'                => new sfValidatorBoolean(),
      'sf_guard_user_permission_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'sf_guard_user_group_list'      => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'etiqueta_politico_list'        => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Etiqueta', 'required' => false)),
      'etiqueta_partido_list'         => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Etiqueta', 'required' => false)),
      'etiqueta_propuesta_list'       => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Etiqueta', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => array('username')))
    );

    $this->widgetSchema->setNameFormat('sf_guard_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['sf_guard_user_permission_list']))
    {
      $values = array();
      foreach ($this->object->getsfGuardUserPermissions() as $obj)
      {
        $values[] = $obj->getPermissionId();
      }

      $this->setDefault('sf_guard_user_permission_list', $values);
    }

    if (isset($this->widgetSchema['sf_guard_user_group_list']))
    {
      $values = array();
      foreach ($this->object->getsfGuardUserGroups() as $obj)
      {
        $values[] = $obj->getGroupId();
      }

      $this->setDefault('sf_guard_user_group_list', $values);
    }

    if (isset($this->widgetSchema['etiqueta_politico_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPoliticos() as $obj)
      {
        $values[] = $obj->getEtiquetaId();
      }

      $this->setDefault('etiqueta_politico_list', $values);
    }

    if (isset($this->widgetSchema['etiqueta_partido_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPartidos() as $obj)
      {
        $values[] = $obj->getEtiquetaId();
      }

      $this->setDefault('etiqueta_partido_list', $values);
    }

    if (isset($this->widgetSchema['etiqueta_propuesta_list']))
    {
      $values = array();
      foreach ($this->object->getEtiquetaPropuestas() as $obj)
      {
        $values[] = $obj->getEtiquetaId();
      }

      $this->setDefault('etiqueta_propuesta_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savesfGuardUserPermissionList($con);
    $this->savesfGuardUserGroupList($con);
    $this->saveEtiquetaPoliticoList($con);
    $this->saveEtiquetaPartidoList($con);
    $this->saveEtiquetaPropuestaList($con);
  }

  public function savesfGuardUserPermissionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sf_guard_user_permission_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(sfGuardUserPermissionPeer::USER_ID, $this->object->getPrimaryKey());
    sfGuardUserPermissionPeer::doDelete($c, $con);

    $values = $this->getValue('sf_guard_user_permission_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new sfGuardUserPermission();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setPermissionId($value);
        $obj->save();
      }
    }
  }

  public function savesfGuardUserGroupList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sf_guard_user_group_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(sfGuardUserGroupPeer::USER_ID, $this->object->getPrimaryKey());
    sfGuardUserGroupPeer::doDelete($c, $con);

    $values = $this->getValue('sf_guard_user_group_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new sfGuardUserGroup();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setGroupId($value);
        $obj->save();
      }
    }
  }

  public function saveEtiquetaPoliticoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_politico_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPoliticoPeer::SF_GUARD_USER_ID, $this->object->getPrimaryKey());
    EtiquetaPoliticoPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_politico_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPolitico();
        $obj->setSfGuardUserId($this->object->getPrimaryKey());
        $obj->setEtiquetaId($value);
        $obj->save();
      }
    }
  }

  public function saveEtiquetaPartidoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_partido_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPartidoPeer::SF_GUARD_USER_ID, $this->object->getPrimaryKey());
    EtiquetaPartidoPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_partido_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPartido();
        $obj->setSfGuardUserId($this->object->getPrimaryKey());
        $obj->setEtiquetaId($value);
        $obj->save();
      }
    }
  }

  public function saveEtiquetaPropuestaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['etiqueta_propuesta_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EtiquetaPropuestaPeer::SF_GUARD_USER_ID, $this->object->getPrimaryKey());
    EtiquetaPropuestaPeer::doDelete($c, $con);

    $values = $this->getValue('etiqueta_propuesta_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EtiquetaPropuesta();
        $obj->setSfGuardUserId($this->object->getPrimaryKey());
        $obj->setEtiquetaId($value);
        $obj->save();
      }
    }
  }

}

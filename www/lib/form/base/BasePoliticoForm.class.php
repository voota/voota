<?php

/**
 * Politico form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'url_key'                   => new sfWidgetFormInput(),
      'alias'                     => new sfWidgetFormInput(),
      'nombre'                    => new sfWidgetFormInput(),
      'apellidos'                 => new sfWidgetFormInput(),
      'email'                     => new sfWidgetFormInput(),
      'sexo'                      => new sfWidgetFormInput(),
      'fecha_nacimiento'          => new sfWidgetFormDate(),
      'pais'                      => new sfWidgetFormInput(),
      'residencia'                => new sfWidgetFormInput(),
      'sf_guard_user_profile_id'  => new sfWidgetFormPropelChoice(array('model' => 'SfGuardUserProfile', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'partido_id'                => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'partido_txt'               => new sfWidgetFormInput(),
      'imagen'                    => new sfWidgetFormInput(),
      'vanity'                    => new sfWidgetFormInput(),
      'lugar_nacimiento'          => new sfWidgetFormInput(),
      'sumu'                      => new sfWidgetFormInput(),
      'sumd'                      => new sfWidgetFormInput(),
      'relacion'                  => new sfWidgetFormInput(),
      'hijos'                     => new sfWidgetFormInput(),
      'hijas'                     => new sfWidgetFormInput(),
      'politico_institucion_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Institucion')),
      'politico_lista_list'       => new sfWidgetFormPropelChoiceMany(array('model' => 'Lista')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'url_key'                   => new sfValidatorString(array('max_length' => 45)),
      'alias'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 45)),
      'apellidos'                 => new sfValidatorString(array('max_length' => 150)),
      'email'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'sexo'                      => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'fecha_nacimiento'          => new sfValidatorDate(array('required' => false)),
      'pais'                      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'residencia'                => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'sf_guard_user_profile_id'  => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'partido_id'                => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'partido_txt'               => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vanity'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'lugar_nacimiento'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'sumu'                      => new sfValidatorInteger(),
      'sumd'                      => new sfValidatorInteger(),
      'relacion'                  => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'hijos'                     => new sfValidatorInteger(array('required' => false)),
      'hijas'                     => new sfValidatorInteger(array('required' => false)),
      'politico_institucion_list' => new sfValidatorPropelChoiceMany(array('model' => 'Institucion', 'required' => false)),
      'politico_lista_list'       => new sfValidatorPropelChoiceMany(array('model' => 'Lista', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Politico', 'column' => array('vanity')))
    );

    $this->widgetSchema->setNameFormat('politico[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Politico';
  }

  public function getI18nModelName()
  {
    return 'PoliticoI18n';
  }

  public function getI18nFormClass()
  {
    return 'PoliticoI18nForm';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['politico_institucion_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoInstitucions() as $obj)
      {
        $values[] = $obj->getInstitucionId();
      }

      $this->setDefault('politico_institucion_list', $values);
    }

    if (isset($this->widgetSchema['politico_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoListas() as $obj)
      {
        $values[] = $obj->getListaId();
      }

      $this->setDefault('politico_lista_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePoliticoInstitucionList($con);
    $this->savePoliticoListaList($con);
  }

  public function savePoliticoInstitucionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['politico_institucion_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PoliticoInstitucionPeer::POLITICO_ID, $this->object->getPrimaryKey());
    PoliticoInstitucionPeer::doDelete($c, $con);

    $values = $this->getValue('politico_institucion_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PoliticoInstitucion();
        $obj->setPoliticoId($this->object->getPrimaryKey());
        $obj->setInstitucionId($value);
        $obj->save();
      }
    }
  }

  public function savePoliticoListaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['politico_lista_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PoliticoListaPeer::POLITICO_ID, $this->object->getPrimaryKey());
    PoliticoListaPeer::doDelete($c, $con);

    $values = $this->getValue('politico_lista_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PoliticoLista();
        $obj->setPoliticoId($this->object->getPrimaryKey());
        $obj->setListaId($value);
        $obj->save();
      }
    }
  }

}

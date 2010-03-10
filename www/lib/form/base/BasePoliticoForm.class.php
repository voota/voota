<?php

/**
 * Politico form base class.
 *
 * @method Politico getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePoliticoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'alias'                     => new sfWidgetFormInputText(),
      'nombre'                    => new sfWidgetFormInputText(),
      'apellidos'                 => new sfWidgetFormInputText(),
      'email'                     => new sfWidgetFormInputText(),
      'sexo'                      => new sfWidgetFormInputText(),
      'fecha_nacimiento'          => new sfWidgetFormDate(),
      'pais'                      => new sfWidgetFormInputText(),
      'residencia'                => new sfWidgetFormInputText(),
      'sf_guard_user_id'          => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'modified_at'               => new sfWidgetFormDateTime(),
      'partido_id'                => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'partido_txt'               => new sfWidgetFormInputText(),
      'imagen'                    => new sfWidgetFormInputText(),
      'vanity'                    => new sfWidgetFormInputText(),
      'lugar_nacimiento'          => new sfWidgetFormInputText(),
      'sumu'                      => new sfWidgetFormInputText(),
      'sumd'                      => new sfWidgetFormInputText(),
      'relacion'                  => new sfWidgetFormInputText(),
      'hijos'                     => new sfWidgetFormInputText(),
      'hijas'                     => new sfWidgetFormInputText(),
      'politico_lista_list'       => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Lista')),
      'politico_institucion_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Institucion')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'alias'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 45)),
      'apellidos'                 => new sfValidatorString(array('max_length' => 150)),
      'email'                     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'sexo'                      => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'fecha_nacimiento'          => new sfValidatorDate(array('required' => false)),
      'pais'                      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'residencia'                => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'sf_guard_user_id'          => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'modified_at'               => new sfValidatorDateTime(array('required' => false)),
      'partido_id'                => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'partido_txt'               => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vanity'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'lugar_nacimiento'          => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'sumu'                      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'sumd'                      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'relacion'                  => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'hijos'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'hijas'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'politico_lista_list'       => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Lista', 'required' => false)),
      'politico_institucion_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Institucion', 'required' => false)),
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

    if (isset($this->widgetSchema['politico_lista_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoListas() as $obj)
      {
        $values[] = $obj->getListaId();
      }

      $this->setDefault('politico_lista_list', $values);
    }

    if (isset($this->widgetSchema['politico_institucion_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoInstitucions() as $obj)
      {
        $values[] = $obj->getInstitucionId();
      }

      $this->setDefault('politico_institucion_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePoliticoListaList($con);
    $this->savePoliticoInstitucionList($con);
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

    if (null === $con)
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

    if (null === $con)
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

}

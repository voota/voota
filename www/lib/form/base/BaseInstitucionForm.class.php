<?php

/**
 * Institucion form base class.
 *
 * @method Institucion getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseInstitucionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'geo_id'                    => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'disabled'                  => new sfWidgetFormInputText(),
      'orden'                     => new sfWidgetFormInputText(),
      'url'                       => new sfWidgetFormInputText(),
      'imagen'                    => new sfWidgetFormInputText(),
      'is_active'                 => new sfWidgetFormInputCheckbox(),
      'is_main'                   => new sfWidgetFormInputCheckbox(),
      'eleccion_institucion_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Eleccion')),
      'politico_institucion_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Politico')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'Institucion', 'column' => 'id', 'required' => false)),
      'geo_id'                    => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id', 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'disabled'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'orden'                     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'url'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'is_active'                 => new sfValidatorBoolean(),
      'is_main'                   => new sfValidatorBoolean(),
      'eleccion_institucion_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Eleccion', 'required' => false)),
      'politico_institucion_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Politico', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('institucion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Institucion';
  }

  public function getI18nModelName()
  {
    return 'InstitucionI18n';
  }

  public function getI18nFormClass()
  {
    return 'InstitucionI18nForm';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['eleccion_institucion_list']))
    {
      $values = array();
      foreach ($this->object->getEleccionInstitucions() as $obj)
      {
        $values[] = $obj->getEleccionId();
      }

      $this->setDefault('eleccion_institucion_list', $values);
    }

    if (isset($this->widgetSchema['politico_institucion_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoInstitucions() as $obj)
      {
        $values[] = $obj->getPoliticoId();
      }

      $this->setDefault('politico_institucion_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEleccionInstitucionList($con);
    $this->savePoliticoInstitucionList($con);
  }

  public function saveEleccionInstitucionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['eleccion_institucion_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(EleccionInstitucionPeer::INSTITUCION_ID, $this->object->getPrimaryKey());
    EleccionInstitucionPeer::doDelete($c, $con);

    $values = $this->getValue('eleccion_institucion_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EleccionInstitucion();
        $obj->setInstitucionId($this->object->getPrimaryKey());
        $obj->setEleccionId($value);
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
    $c->add(PoliticoInstitucionPeer::INSTITUCION_ID, $this->object->getPrimaryKey());
    PoliticoInstitucionPeer::doDelete($c, $con);

    $values = $this->getValue('politico_institucion_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PoliticoInstitucion();
        $obj->setInstitucionId($this->object->getPrimaryKey());
        $obj->setPoliticoId($value);
        $obj->save();
      }
    }
  }

}

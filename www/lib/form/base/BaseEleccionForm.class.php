<?php

/**
 * Eleccion form base class.
 *
 * @method Eleccion getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEleccionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nombre_corto'              => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'eleccion_institucion_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Institucion')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id', 'required' => false)),
      'nombre_corto'              => new sfValidatorString(array('max_length' => 45)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'eleccion_institucion_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Institucion', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eleccion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Eleccion';
  }

  public function getI18nModelName()
  {
    return 'EleccionI18n';
  }

  public function getI18nFormClass()
  {
    return 'EleccionI18nForm';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['eleccion_institucion_list']))
    {
      $values = array();
      foreach ($this->object->getEleccionInstitucions() as $obj)
      {
        $values[] = $obj->getInstitucionId();
      }

      $this->setDefault('eleccion_institucion_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveEleccionInstitucionList($con);
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
    $c->add(EleccionInstitucionPeer::ELECCION_ID, $this->object->getPrimaryKey());
    EleccionInstitucionPeer::doDelete($c, $con);

    $values = $this->getValue('eleccion_institucion_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new EleccionInstitucion();
        $obj->setEleccionId($this->object->getPrimaryKey());
        $obj->setInstitucionId($value);
        $obj->save();
      }
    }
  }

}

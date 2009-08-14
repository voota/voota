<?php

/**
 * Institucion form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseInstitucionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'nombre'                    => new sfWidgetFormInput(),
      'region_id'                 => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'eleccion_institucion_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Eleccion')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'Institucion', 'column' => 'id', 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 150)),
      'region_id'                 => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id', 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'eleccion_institucion_list' => new sfValidatorPropelChoiceMany(array('model' => 'Eleccion', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('institucion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Institucion';
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

    if (is_null($con))
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

}

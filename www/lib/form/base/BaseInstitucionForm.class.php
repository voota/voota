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
      'geo_id'                    => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'disabled'                  => new sfWidgetFormInput(),
      'orden'                     => new sfWidgetFormInput(),
      'nombre_corto'              => new sfWidgetFormInput(),
      'url'                       => new sfWidgetFormInput(),
      'imagen'                    => new sfWidgetFormInput(),
      'vanity'                    => new sfWidgetFormInput(),
      'politico_institucion_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Politico')),
      'eleccion_institucion_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Eleccion')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'Institucion', 'column' => 'id', 'required' => false)),
      'nombre'                    => new sfValidatorString(array('max_length' => 150)),
      'geo_id'                    => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id', 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'disabled'                  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'orden'                     => new sfValidatorInteger(array('required' => false)),
      'nombre_corto'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'url'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'vanity'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'politico_institucion_list' => new sfValidatorPropelChoiceMany(array('model' => 'Politico', 'required' => false)),
      'eleccion_institucion_list' => new sfValidatorPropelChoiceMany(array('model' => 'Eleccion', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Institucion', 'column' => array('vanity')))
    );

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

    if (isset($this->widgetSchema['politico_institucion_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoInstitucions() as $obj)
      {
        $values[] = $obj->getPoliticoId();
      }

      $this->setDefault('politico_institucion_list', $values);
    }

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

    $this->savePoliticoInstitucionList($con);
    $this->saveEleccionInstitucionList($con);
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

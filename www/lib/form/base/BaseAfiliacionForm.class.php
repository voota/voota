<?php

/**
 * Afiliacion form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAfiliacionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'fecha_inicio'             => new sfWidgetFormDate(),
      'fecha_fin'                => new sfWidgetFormDate(),
      'partido_id'               => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => false)),
      'created_at'               => new sfWidgetFormDateTime(),
      'politico_afiliacion_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'Politico')),
      'partido_afiliacion_list'  => new sfWidgetFormPropelChoiceMany(array('model' => 'Partido')),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorPropelChoice(array('model' => 'Afiliacion', 'column' => 'id', 'required' => false)),
      'fecha_inicio'             => new sfValidatorDate(array('required' => false)),
      'fecha_fin'                => new sfValidatorDate(array('required' => false)),
      'partido_id'               => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id')),
      'created_at'               => new sfValidatorDateTime(array('required' => false)),
      'politico_afiliacion_list' => new sfValidatorPropelChoiceMany(array('model' => 'Politico', 'required' => false)),
      'partido_afiliacion_list'  => new sfValidatorPropelChoiceMany(array('model' => 'Partido', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('afiliacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Afiliacion';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['politico_afiliacion_list']))
    {
      $values = array();
      foreach ($this->object->getPoliticoAfiliacions() as $obj)
      {
        $values[] = $obj->getPoliticoId();
      }

      $this->setDefault('politico_afiliacion_list', $values);
    }

    if (isset($this->widgetSchema['partido_afiliacion_list']))
    {
      $values = array();
      foreach ($this->object->getPartidoAfiliacions() as $obj)
      {
        $values[] = $obj->getPartidoId();
      }

      $this->setDefault('partido_afiliacion_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePoliticoAfiliacionList($con);
    $this->savePartidoAfiliacionList($con);
  }

  public function savePoliticoAfiliacionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['politico_afiliacion_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PoliticoAfiliacionPeer::AFILIACION_ID, $this->object->getPrimaryKey());
    PoliticoAfiliacionPeer::doDelete($c, $con);

    $values = $this->getValue('politico_afiliacion_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PoliticoAfiliacion();
        $obj->setAfiliacionId($this->object->getPrimaryKey());
        $obj->setPoliticoId($value);
        $obj->save();
      }
    }
  }

  public function savePartidoAfiliacionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['partido_afiliacion_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PartidoAfiliacionPeer::AFILIACION_ID, $this->object->getPrimaryKey());
    PartidoAfiliacionPeer::doDelete($c, $con);

    $values = $this->getValue('partido_afiliacion_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PartidoAfiliacion();
        $obj->setAfiliacionId($this->object->getPrimaryKey());
        $obj->setPartidoId($value);
        $obj->save();
      }
    }
  }

}

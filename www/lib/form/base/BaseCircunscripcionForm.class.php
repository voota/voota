<?php

/**
 * Circunscripcion form base class.
 *
 * @method Circunscripcion getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCircunscripcionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'geo_id'   => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => false)),
      'escanyos' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'Circunscripcion', 'column' => 'id', 'required' => false)),
      'geo_id'   => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id')),
      'escanyos' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('circunscripcion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Circunscripcion';
  }


}

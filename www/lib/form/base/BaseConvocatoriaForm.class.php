<?php

/**
 * Convocatoria form base class.
 *
 * @method Convocatoria getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseConvocatoriaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInputText(),
      'eleccion_id' => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => false)),
      'fecha'       => new sfWidgetFormDate(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id', 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 45)),
      'eleccion_id' => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id')),
      'fecha'       => new sfValidatorDate(),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('convocatoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convocatoria';
  }


}

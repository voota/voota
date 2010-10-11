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
      'id'             => new sfWidgetFormInputHidden(),
      'eleccion_id'    => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => false)),
      'nombre'         => new sfWidgetFormInputText(),
      'fecha'          => new sfWidgetFormDate(),
      'created_at'     => new sfWidgetFormDateTime(),
      'imagen'         => new sfWidgetFormInputText(),
      'closed_at'      => new sfWidgetFormDateTime(),
      'total_escanyos' => new sfWidgetFormInputText(),
      'min_sumu'       => new sfWidgetFormInputText(),
      'min_sumd'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id', 'required' => false)),
      'eleccion_id'    => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id')),
      'nombre'         => new sfValidatorString(array('max_length' => 45)),
      'fecha'          => new sfValidatorDate(),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'imagen'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'closed_at'      => new sfValidatorDateTime(array('required' => false)),
      'total_escanyos' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'min_sumu'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'min_sumd'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Convocatoria', 'column' => array('eleccion_id', 'nombre')))
    );

    $this->widgetSchema->setNameFormat('convocatoria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convocatoria';
  }

  public function getI18nModelName()
  {
    return 'ConvocatoriaI18n';
  }

  public function getI18nFormClass()
  {
    return 'ConvocatoriaI18nForm';
  }

}

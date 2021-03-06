<?php

/**
 * EleccionI18n form base class.
 *
 * @method EleccionI18n getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEleccionI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'nombre_corto' => new sfWidgetFormInputText(),
      'nombre'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id', 'required' => false)),
      'culture'      => new sfValidatorPropelChoice(array('model' => 'EleccionI18n', 'column' => 'culture', 'required' => false)),
      'nombre_corto' => new sfValidatorString(array('max_length' => 45)),
      'nombre'       => new sfValidatorString(array('max_length' => 150)),
    ));

    $this->widgetSchema->setNameFormat('eleccion_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EleccionI18n';
  }


}

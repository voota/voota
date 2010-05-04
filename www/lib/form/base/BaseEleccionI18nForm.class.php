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
      'id'          => new sfWidgetFormInputHidden(),
      'culture'     => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInputText(),
      'descripcion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Eleccion', 'column' => 'id', 'required' => false)),
      'culture'     => new sfValidatorPropelChoice(array('model' => 'EleccionI18n', 'column' => 'culture', 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 150)),
      'descripcion' => new sfValidatorString(array('max_length' => 600, 'required' => false)),
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

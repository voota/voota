<?php

/**
 * ConvocatoriaI18n form base class.
 *
 * @method ConvocatoriaI18n getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseConvocatoriaI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'culture'     => new sfWidgetFormInputHidden(),
      'descripcion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id', 'required' => false)),
      'culture'     => new sfValidatorPropelChoice(array('model' => 'ConvocatoriaI18n', 'column' => 'culture', 'required' => false)),
      'descripcion' => new sfValidatorString(array('max_length' => 600, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('convocatoria_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ConvocatoriaI18n';
  }


}

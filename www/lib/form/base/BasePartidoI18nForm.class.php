<?php

/**
 * PartidoI18n form base class.
 *
 * @method PartidoI18n getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePartidoI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'nombre'       => new sfWidgetFormInputText(),
      'presentacion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'culture'      => new sfValidatorPropelChoice(array('model' => 'PartidoI18n', 'column' => 'culture', 'required' => false)),
      'nombre'       => new sfValidatorString(array('max_length' => 150)),
      'presentacion' => new sfValidatorString(array('max_length' => 600)),
    ));

    $this->widgetSchema->setNameFormat('partido_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidoI18n';
  }


}

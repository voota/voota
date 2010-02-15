<?php

/**
 * PoliticoI18n form base class.
 *
 * @method PoliticoI18n getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePoliticoI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'formacion'    => new sfWidgetFormInputText(),
      'presentacion' => new sfWidgetFormInputText(),
      'bio'          => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'culture'      => new sfValidatorPropelChoice(array('model' => 'PoliticoI18n', 'column' => 'culture', 'required' => false)),
      'formacion'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'presentacion' => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'bio'          => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoI18n';
  }


}

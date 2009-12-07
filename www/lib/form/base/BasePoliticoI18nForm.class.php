<?php

/**
 * PoliticoI18n form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'formacion'    => new sfWidgetFormInput(),
      'presentacion' => new sfWidgetFormInput(),
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
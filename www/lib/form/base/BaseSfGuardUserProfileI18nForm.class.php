<?php

/**
 * SfGuardUserProfileI18n form base class.
 *
 * @method SfGuardUserProfileI18n getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSfGuardUserProfileI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'presentacion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'culture'      => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfileI18n', 'column' => 'culture', 'required' => false)),
      'presentacion' => new sfValidatorString(array('max_length' => 600, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfGuardUserProfileI18n';
  }


}

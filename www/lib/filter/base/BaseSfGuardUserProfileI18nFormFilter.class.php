<?php

/**
 * SfGuardUserProfileI18n filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSfGuardUserProfileI18nFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'presentacion' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'presentacion' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_i18n_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfGuardUserProfileI18n';
  }

  public function getFields()
  {
    return array(
      'id'           => 'ForeignKey',
      'culture'      => 'Text',
      'presentacion' => 'Text',
    );
  }
}

<?php

/**
 * InstitucionI18n form base class.
 *
 * @method InstitucionI18n getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseInstitucionI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'culture'      => new sfWidgetFormInputHidden(),
      'vanity'       => new sfWidgetFormInputText(),
      'nombre_corto' => new sfWidgetFormInputText(),
      'nombre'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Institucion', 'column' => 'id', 'required' => false)),
      'culture'      => new sfValidatorPropelChoice(array('model' => 'InstitucionI18n', 'column' => 'culture', 'required' => false)),
      'vanity'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nombre_corto' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nombre'       => new sfValidatorString(array('max_length' => 150)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'InstitucionI18n', 'column' => array('vanity', 'culture')))
    );

    $this->widgetSchema->setNameFormat('institucion_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InstitucionI18n';
  }


}

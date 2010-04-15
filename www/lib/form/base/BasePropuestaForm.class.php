<?php

/**
 * Propuesta form base class.
 *
 * @method Propuesta getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePropuestaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'titulo'           => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormInputText(),
      'culture'          => new sfWidgetFormInputText(),
      'imagen'           => new sfWidgetFormInputText(),
      'doc'              => new sfWidgetFormInputText(),
      'sf_guard_user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'sumu'             => new sfWidgetFormInputText(),
      'sumd'             => new sfWidgetFormInputText(),
      'is_active'        => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
      'modified_at'      => new sfWidgetFormDateTime(),
      'vanity'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Propuesta', 'column' => 'id', 'required' => false)),
      'titulo'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('max_length' => 600, 'required' => false)),
      'culture'          => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'imagen'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'doc'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'sf_guard_user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'sumu'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'sumd'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'is_active'        => new sfValidatorBoolean(),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'modified_at'      => new sfValidatorDateTime(array('required' => false)),
      'vanity'           => new sfValidatorString(array('max_length' => 150)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Propuesta', 'column' => array('vanity')))
    );

    $this->widgetSchema->setNameFormat('propuesta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Propuesta';
  }


}

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
      'sf_guard_user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Propuesta', 'column' => 'id', 'required' => false)),
      'titulo'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('max_length' => 600, 'required' => false)),
      'culture'          => new sfValidatorString(array('max_length' => 7, 'required' => false)),
      'imagen'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'doc'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'sf_guard_user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('propuesta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Propuesta';
  }


}

<?php

/**
 * Enlace form base class.
 *
 * @method Enlace getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseEnlaceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'url'              => new sfWidgetFormInputText(),
      'tipo'             => new sfWidgetFormInputText(),
      'partido_id'       => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id'      => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'orden'            => new sfWidgetFormInputText(),
      'mostrar'          => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'culture'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Enlace', 'column' => 'id', 'required' => false)),
      'url'              => new sfValidatorString(array('max_length' => 150)),
      'tipo'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'partido_id'       => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'politico_id'      => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'sf_guard_user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'orden'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'mostrar'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'culture'          => new sfValidatorString(array('max_length' => 7, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('enlace[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Enlace';
  }


}

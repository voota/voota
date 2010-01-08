<?php

/**
 * Enlace form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseEnlaceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'url'              => new sfWidgetFormInput(),
      'tipo'             => new sfWidgetFormInput(),
      'partido_id'       => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id'      => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'orden'            => new sfWidgetFormInput(),
      'mostrar'          => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Enlace', 'column' => 'id', 'required' => false)),
      'url'              => new sfValidatorString(array('max_length' => 150)),
      'tipo'             => new sfValidatorInteger(array('required' => false)),
      'partido_id'       => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'politico_id'      => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'sf_guard_user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'orden'            => new sfValidatorInteger(array('required' => false)),
      'mostrar'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
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

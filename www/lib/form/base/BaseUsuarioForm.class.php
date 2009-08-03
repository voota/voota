<?php

/**
 * Usuario form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUsuarioForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'email'            => new sfWidgetFormInput(),
      'clave'            => new sfWidgetFormInput(),
      'acepta_mensajes'  => new sfWidgetFormInput(),
      'nombre'           => new sfWidgetFormInput(),
      'apellidos'        => new sfWidgetFormInput(),
      'fecha_nacimiento' => new sfWidgetFormDate(),
      'pais'             => new sfWidgetFormInput(),
      'formacion'        => new sfWidgetFormInput(),
      'residencia'       => new sfWidgetFormInput(),
      'presentacion'     => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'email'            => new sfValidatorString(array('max_length' => 150)),
      'clave'            => new sfValidatorString(array('max_length' => 45)),
      'acepta_mensajes'  => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 45)),
      'apellidos'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha_nacimiento' => new sfValidatorDate(array('required' => false)),
      'pais'             => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'formacion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residencia'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'presentacion'     => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }


}

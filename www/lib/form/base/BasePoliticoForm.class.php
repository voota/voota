<?php

/**
 * Politico form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'url_key'          => new sfWidgetFormInput(),
      'alias'            => new sfWidgetFormInput(),
      'nombre'           => new sfWidgetFormInput(),
      'apellidos'        => new sfWidgetFormInput(),
      'email'            => new sfWidgetFormInput(),
      'sexo'             => new sfWidgetFormInput(),
      'fecha_nacimiento' => new sfWidgetFormDate(),
      'pais'             => new sfWidgetFormInput(),
      'formacion'        => new sfWidgetFormInput(),
      'residencia'       => new sfWidgetFormInput(),
      'presentacion'     => new sfWidgetFormInput(),
      'usuario_id'       => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'partido_id'       => new sfWidgetFormInput(),
      'bio'              => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'url_key'          => new sfValidatorString(array('max_length' => 45)),
      'alias'            => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 45)),
      'apellidos'        => new sfValidatorString(array('max_length' => 150)),
      'email'            => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'sexo'             => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'fecha_nacimiento' => new sfValidatorDate(array('required' => false)),
      'pais'             => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'formacion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residencia'       => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'presentacion'     => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'usuario_id'       => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'partido_id'       => new sfValidatorInteger(array('required' => false)),
      'bio'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Politico';
  }


}

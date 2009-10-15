<?php

/**
 * SfGuardUserProfile form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'user_id'                  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'clave'                    => new sfWidgetFormInput(),
      'acepta_mensajes'          => new sfWidgetFormInput(),
      'nombre'                   => new sfWidgetFormInput(),
      'apellidos'                => new sfWidgetFormInput(),
      'fecha_nacimiento'         => new sfWidgetFormDate(),
      'pais'                     => new sfWidgetFormInput(),
      'formacion'                => new sfWidgetFormInput(),
      'residencia'               => new sfWidgetFormInput(),
      'presentacion'             => new sfWidgetFormInput(),
      'created_at'               => new sfWidgetFormDateTime(),
      'vanity'                   => new sfWidgetFormInput(),
      'imagen'                   => new sfWidgetFormInput(),
      'sf_guard_user_profilecol' => new sfWidgetFormInput(),
      'codigo'                   => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'user_id'                  => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'clave'                    => new sfValidatorString(array('max_length' => 45)),
      'acepta_mensajes'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'nombre'                   => new sfValidatorString(array('max_length' => 45)),
      'apellidos'                => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha_nacimiento'         => new sfValidatorDate(array('required' => false)),
      'pais'                     => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'formacion'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residencia'               => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'presentacion'             => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'created_at'               => new sfValidatorDateTime(array('required' => false)),
      'vanity'                   => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'imagen'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'sf_guard_user_profilecol' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'codigo'                   => new sfValidatorString(array('max_length' => 45, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfGuardUserProfile';
  }


}

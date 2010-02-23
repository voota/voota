<?php

/**
 * SfGuardUserProfile form base class.
 *
 * @method SfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'user_id'                   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'nombre'                    => new sfWidgetFormInputText(),
      'apellidos'                 => new sfWidgetFormInputText(),
      'fecha_nacimiento'          => new sfWidgetFormDate(),
      'pais'                      => new sfWidgetFormInputText(),
      'formacion'                 => new sfWidgetFormInputText(),
      'residencia'                => new sfWidgetFormInputText(),
      'presentacion'              => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'vanity'                    => new sfWidgetFormInputText(),
      'imagen'                    => new sfWidgetFormInputText(),
      'codigo'                    => new sfWidgetFormInputText(),
      'papel_voota'               => new sfWidgetFormInputText(),
      'mails_comentarios'         => new sfWidgetFormInputText(),
      'mails_noticias'            => new sfWidgetFormInputText(),
      'mails_contacto'            => new sfWidgetFormInputText(),
      'mails_seguidor'            => new sfWidgetFormInputText(),
      'numero_socio'              => new sfWidgetFormInputText(),
      'facebook_uid'              => new sfWidgetFormInputText(),
      'email'                     => new sfWidgetFormInputText(),
      'email_hash'                => new sfWidgetFormInputText(),
      'fb_publish_votos'          => new sfWidgetFormInputCheckbox(),
      'fb_publish_votos_otros'    => new sfWidgetFormInputCheckbox(),
      'fb_publish_cambios_perfil' => new sfWidgetFormInputCheckbox(),
      'fb_tip'                    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorPropelChoice(array('model' => 'SfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'user_id'                   => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'nombre'                    => new sfValidatorString(array('max_length' => 45)),
      'apellidos'                 => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fecha_nacimiento'          => new sfValidatorDate(array('required' => false)),
      'pais'                      => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'formacion'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residencia'                => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'presentacion'              => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'created_at'                => new sfValidatorDateTime(array('required' => false)),
      'vanity'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'imagen'                    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'codigo'                    => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'papel_voota'               => new sfValidatorString(array('max_length' => 280, 'required' => false)),
      'mails_comentarios'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'mails_noticias'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'mails_contacto'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'mails_seguidor'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'numero_socio'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'facebook_uid'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'email'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_hash'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fb_publish_votos'          => new sfValidatorBoolean(),
      'fb_publish_votos_otros'    => new sfValidatorBoolean(),
      'fb_publish_cambios_perfil' => new sfValidatorBoolean(),
      'fb_tip'                    => new sfValidatorBoolean(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SfGuardUserProfile', 'column' => array('vanity')))
    );

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfGuardUserProfile';
  }


}

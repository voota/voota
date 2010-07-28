<?php

/**
 * SfGuardUserProfile filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSfGuardUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                   => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'nombre'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellidos'                 => new sfWidgetFormFilterInput(),
      'fecha_nacimiento'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pais'                      => new sfWidgetFormFilterInput(),
      'formacion'                 => new sfWidgetFormFilterInput(),
      'residencia'                => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'vanity'                    => new sfWidgetFormFilterInput(),
      'imagen'                    => new sfWidgetFormFilterInput(),
      'codigo'                    => new sfWidgetFormFilterInput(),
      'papel_voota'               => new sfWidgetFormFilterInput(),
      'mails_comentarios'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mails_noticias'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mails_contacto'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mails_seguidor'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'numero_socio'              => new sfWidgetFormFilterInput(),
      'facebook_uid'              => new sfWidgetFormFilterInput(),
      'email'                     => new sfWidgetFormFilterInput(),
      'email_hash'                => new sfWidgetFormFilterInput(),
      'fb_publish_votos'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fb_publish_votos_otros'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fb_publish_cambios_perfil' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fb_tip'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'anonymous'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'user_id'                   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'nombre'                    => new sfValidatorPass(array('required' => false)),
      'apellidos'                 => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pais'                      => new sfValidatorPass(array('required' => false)),
      'formacion'                 => new sfValidatorPass(array('required' => false)),
      'residencia'                => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'vanity'                    => new sfValidatorPass(array('required' => false)),
      'imagen'                    => new sfValidatorPass(array('required' => false)),
      'codigo'                    => new sfValidatorPass(array('required' => false)),
      'papel_voota'               => new sfValidatorPass(array('required' => false)),
      'mails_comentarios'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mails_noticias'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mails_contacto'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mails_seguidor'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'numero_socio'              => new sfValidatorPass(array('required' => false)),
      'facebook_uid'              => new sfValidatorPass(array('required' => false)),
      'email'                     => new sfValidatorPass(array('required' => false)),
      'email_hash'                => new sfValidatorPass(array('required' => false)),
      'fb_publish_votos'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fb_publish_votos_otros'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fb_publish_cambios_perfil' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fb_tip'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'anonymous'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfGuardUserProfile';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'user_id'                   => 'ForeignKey',
      'nombre'                    => 'Text',
      'apellidos'                 => 'Text',
      'fecha_nacimiento'          => 'Date',
      'pais'                      => 'Text',
      'formacion'                 => 'Text',
      'residencia'                => 'Text',
      'created_at'                => 'Date',
      'vanity'                    => 'Text',
      'imagen'                    => 'Text',
      'codigo'                    => 'Text',
      'papel_voota'               => 'Text',
      'mails_comentarios'         => 'Number',
      'mails_noticias'            => 'Number',
      'mails_contacto'            => 'Number',
      'mails_seguidor'            => 'Number',
      'numero_socio'              => 'Text',
      'facebook_uid'              => 'Text',
      'email'                     => 'Text',
      'email_hash'                => 'Text',
      'fb_publish_votos'          => 'Boolean',
      'fb_publish_votos_otros'    => 'Boolean',
      'fb_publish_cambios_perfil' => 'Boolean',
      'fb_tip'                    => 'Boolean',
      'anonymous'                 => 'Boolean',
    );
  }
}

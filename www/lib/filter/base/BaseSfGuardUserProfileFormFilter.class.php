<?php

/**
 * SfGuardUserProfile filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseSfGuardUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'nombre'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'apellidos'         => new sfWidgetFormFilterInput(),
      'fecha_nacimiento'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pais'              => new sfWidgetFormFilterInput(),
      'formacion'         => new sfWidgetFormFilterInput(),
      'residencia'        => new sfWidgetFormFilterInput(),
      'presentacion'      => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'vanity'            => new sfWidgetFormFilterInput(),
      'imagen'            => new sfWidgetFormFilterInput(),
      'codigo'            => new sfWidgetFormFilterInput(),
      'papel_voota'       => new sfWidgetFormFilterInput(),
      'mails_comentarios' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mails_noticias'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mails_contacto'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mails_seguidor'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'numero_socio'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'nombre'            => new sfValidatorPass(array('required' => false)),
      'apellidos'         => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pais'              => new sfValidatorPass(array('required' => false)),
      'formacion'         => new sfValidatorPass(array('required' => false)),
      'residencia'        => new sfValidatorPass(array('required' => false)),
      'presentacion'      => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'vanity'            => new sfValidatorPass(array('required' => false)),
      'imagen'            => new sfValidatorPass(array('required' => false)),
      'codigo'            => new sfValidatorPass(array('required' => false)),
      'papel_voota'       => new sfValidatorPass(array('required' => false)),
      'mails_comentarios' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mails_noticias'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mails_contacto'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mails_seguidor'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'numero_socio'      => new sfValidatorPass(array('required' => false)),
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
      'id'                => 'Number',
      'user_id'           => 'ForeignKey',
      'nombre'            => 'Text',
      'apellidos'         => 'Text',
      'fecha_nacimiento'  => 'Date',
      'pais'              => 'Text',
      'formacion'         => 'Text',
      'residencia'        => 'Text',
      'presentacion'      => 'Text',
      'created_at'        => 'Date',
      'vanity'            => 'Text',
      'imagen'            => 'Text',
      'codigo'            => 'Text',
      'papel_voota'       => 'Text',
      'mails_comentarios' => 'Number',
      'mails_noticias'    => 'Number',
      'mails_contacto'    => 'Number',
      'mails_seguidor'    => 'Number',
      'numero_socio'      => 'Text',
    );
  }
}

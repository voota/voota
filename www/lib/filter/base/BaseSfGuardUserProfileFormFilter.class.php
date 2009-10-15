<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * SfGuardUserProfile filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSfGuardUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                  => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'clave'                    => new sfWidgetFormFilterInput(),
      'acepta_mensajes'          => new sfWidgetFormFilterInput(),
      'nombre'                   => new sfWidgetFormFilterInput(),
      'apellidos'                => new sfWidgetFormFilterInput(),
      'fecha_nacimiento'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'pais'                     => new sfWidgetFormFilterInput(),
      'formacion'                => new sfWidgetFormFilterInput(),
      'residencia'               => new sfWidgetFormFilterInput(),
      'presentacion'             => new sfWidgetFormFilterInput(),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'vanity'                   => new sfWidgetFormFilterInput(),
      'imagen'                   => new sfWidgetFormFilterInput(),
      'sf_guard_user_profilecol' => new sfWidgetFormFilterInput(),
      'codigo'                   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'                  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'clave'                    => new sfValidatorPass(array('required' => false)),
      'acepta_mensajes'          => new sfValidatorPass(array('required' => false)),
      'nombre'                   => new sfValidatorPass(array('required' => false)),
      'apellidos'                => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pais'                     => new sfValidatorPass(array('required' => false)),
      'formacion'                => new sfValidatorPass(array('required' => false)),
      'residencia'               => new sfValidatorPass(array('required' => false)),
      'presentacion'             => new sfValidatorPass(array('required' => false)),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'vanity'                   => new sfValidatorPass(array('required' => false)),
      'imagen'                   => new sfValidatorPass(array('required' => false)),
      'sf_guard_user_profilecol' => new sfValidatorPass(array('required' => false)),
      'codigo'                   => new sfValidatorPass(array('required' => false)),
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
      'id'                       => 'Number',
      'user_id'                  => 'ForeignKey',
      'clave'                    => 'Text',
      'acepta_mensajes'          => 'Text',
      'nombre'                   => 'Text',
      'apellidos'                => 'Text',
      'fecha_nacimiento'         => 'Date',
      'pais'                     => 'Text',
      'formacion'                => 'Text',
      'residencia'               => 'Text',
      'presentacion'             => 'Text',
      'created_at'               => 'Date',
      'vanity'                   => 'Text',
      'imagen'                   => 'Text',
      'sf_guard_user_profilecol' => 'Text',
      'codigo'                   => 'Text',
    );
  }
}

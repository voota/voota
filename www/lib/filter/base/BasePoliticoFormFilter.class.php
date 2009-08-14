<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Politico filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'url_key'          => new sfWidgetFormFilterInput(),
      'alias'            => new sfWidgetFormFilterInput(),
      'nombre'           => new sfWidgetFormFilterInput(),
      'apellidos'        => new sfWidgetFormFilterInput(),
      'email'            => new sfWidgetFormFilterInput(),
      'sexo'             => new sfWidgetFormFilterInput(),
      'fecha_nacimiento' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'pais'             => new sfWidgetFormFilterInput(),
      'formacion'        => new sfWidgetFormFilterInput(),
      'residencia'       => new sfWidgetFormFilterInput(),
      'presentacion'     => new sfWidgetFormFilterInput(),
      'usuario_id'       => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'partido_id'       => new sfWidgetFormFilterInput(),
      'bio'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'url_key'          => new sfValidatorPass(array('required' => false)),
      'alias'            => new sfValidatorPass(array('required' => false)),
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'apellidos'        => new sfValidatorPass(array('required' => false)),
      'email'            => new sfValidatorPass(array('required' => false)),
      'sexo'             => new sfValidatorPass(array('required' => false)),
      'fecha_nacimiento' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pais'             => new sfValidatorPass(array('required' => false)),
      'formacion'        => new sfValidatorPass(array('required' => false)),
      'residencia'       => new sfValidatorPass(array('required' => false)),
      'presentacion'     => new sfValidatorPass(array('required' => false)),
      'usuario_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuario', 'column' => 'id')),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partido_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bio'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Politico';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'url_key'          => 'Text',
      'alias'            => 'Text',
      'nombre'           => 'Text',
      'apellidos'        => 'Text',
      'email'            => 'Text',
      'sexo'             => 'Text',
      'fecha_nacimiento' => 'Date',
      'pais'             => 'Text',
      'formacion'        => 'Text',
      'residencia'       => 'Text',
      'presentacion'     => 'Text',
      'usuario_id'       => 'ForeignKey',
      'created_at'       => 'Date',
      'partido_id'       => 'Number',
      'bio'              => 'Text',
    );
  }
}

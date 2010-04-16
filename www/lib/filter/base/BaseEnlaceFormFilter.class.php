<?php

/**
 * Enlace filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEnlaceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo'             => new sfWidgetFormFilterInput(),
      'partido_id'       => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id'      => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'propuesta_id'     => new sfWidgetFormPropelChoice(array('model' => 'Propuesta', 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'orden'            => new sfWidgetFormFilterInput(),
      'mostrar'          => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'culture'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'url'              => new sfValidatorPass(array('required' => false)),
      'tipo'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'partido_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'politico_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Politico', 'column' => 'id')),
      'propuesta_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Propuesta', 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'orden'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mostrar'          => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'culture'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('enlace_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Enlace';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'url'              => 'Text',
      'tipo'             => 'Number',
      'partido_id'       => 'ForeignKey',
      'politico_id'      => 'ForeignKey',
      'propuesta_id'     => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
      'orden'            => 'Number',
      'mostrar'          => 'Text',
      'created_at'       => 'Date',
      'culture'          => 'Text',
    );
  }
}

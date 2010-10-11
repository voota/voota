<?php

/**
 * ListaCalle filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseListaCalleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'convocatoria_id'    => new sfWidgetFormPropelChoice(array('model' => 'Convocatoria', 'add_empty' => true)),
      'partido_id'         => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id'        => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'circunscripcion_id' => new sfWidgetFormPropelChoice(array('model' => 'Circunscripcion', 'add_empty' => true)),
      'sumu'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sumd'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'convocatoria_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Convocatoria', 'column' => 'id')),
      'partido_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Partido', 'column' => 'id')),
      'politico_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Politico', 'column' => 'id')),
      'circunscripcion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Circunscripcion', 'column' => 'id')),
      'sumu'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sumd'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('lista_calle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaCalle';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'convocatoria_id'    => 'ForeignKey',
      'partido_id'         => 'ForeignKey',
      'politico_id'        => 'ForeignKey',
      'circunscripcion_id' => 'ForeignKey',
      'sumu'               => 'Number',
      'sumd'               => 'Number',
    );
  }
}

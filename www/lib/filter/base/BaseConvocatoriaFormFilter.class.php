<?php

/**
 * Convocatoria filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseConvocatoriaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'eleccion_id' => new sfWidgetFormPropelChoice(array('model' => 'Eleccion', 'add_empty' => true)),
      'nombre'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'imagen'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'eleccion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Eleccion', 'column' => 'id')),
      'nombre'      => new sfValidatorPass(array('required' => false)),
      'fecha'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'imagen'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('convocatoria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convocatoria';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'eleccion_id' => 'ForeignKey',
      'nombre'      => 'Text',
      'fecha'       => 'Date',
      'created_at'  => 'Date',
      'imagen'      => 'Text',
    );
  }
}

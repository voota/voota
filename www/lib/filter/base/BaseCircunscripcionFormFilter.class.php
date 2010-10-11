<?php

/**
 * Circunscripcion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCircunscripcionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'geo_id'   => new sfWidgetFormPropelChoice(array('model' => 'Geo', 'add_empty' => true)),
      'escanyos' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'geo_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Geo', 'column' => 'id')),
      'escanyos' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('circunscripcion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Circunscripcion';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'geo_id'   => 'ForeignKey',
      'escanyos' => 'Number',
    );
  }
}

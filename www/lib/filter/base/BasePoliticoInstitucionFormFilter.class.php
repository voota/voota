<?php

/**
 * PoliticoInstitucion filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePoliticoInstitucionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_inicio'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_fin'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'cargo'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha_inicio'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'fecha_fin'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'cargo'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_institucion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoInstitucion';
  }

  public function getFields()
  {
    return array(
      'politico_id'    => 'ForeignKey',
      'institucion_id' => 'ForeignKey',
      'fecha_inicio'   => 'Date',
      'fecha_fin'      => 'Date',
      'cargo'          => 'Text',
    );
  }
}

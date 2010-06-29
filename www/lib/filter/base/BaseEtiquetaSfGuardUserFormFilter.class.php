<?php

/**
 * EtiquetaSfGuardUser filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEtiquetaSfGuardUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'fecha'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('etiqueta_sf_guard_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EtiquetaSfGuardUser';
  }

  public function getFields()
  {
    return array(
      'etiqueta_id'      => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
      'fecha'            => 'Date',
    );
  }
}

<?php

/**
 * EleccionI18n filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEleccionI18nFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre_corto' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nombre'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nombre_corto' => new sfValidatorPass(array('required' => false)),
      'nombre'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eleccion_i18n_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EleccionI18n';
  }

  public function getFields()
  {
    return array(
      'id'           => 'ForeignKey',
      'culture'      => 'Text',
      'nombre_corto' => 'Text',
      'nombre'       => 'Text',
    );
  }
}

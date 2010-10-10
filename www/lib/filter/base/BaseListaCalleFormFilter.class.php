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
      'min_sumu'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'min_sumd'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'min_sumu'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'min_sumd'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
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
      'convocatoria_id' => 'ForeignKey',
      'partido_id'      => 'ForeignKey',
      'geo_id'          => 'ForeignKey',
      'politico_id'     => 'ForeignKey',
      'min_sumu'        => 'Number',
      'min_sumd'        => 'Number',
    );
  }
}

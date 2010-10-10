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
      'sumu'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sumd'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
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
      'convocatoria_id'    => 'ForeignKey',
      'partido_id'         => 'ForeignKey',
      'politico_id'        => 'ForeignKey',
      'circunscripcion_id' => 'ForeignKey',
      'sumu'               => 'Number',
      'sumd'               => 'Number',
    );
  }
}

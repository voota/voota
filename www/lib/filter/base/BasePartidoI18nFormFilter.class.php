<?php

/**
 * PartidoI18n filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePartidoI18nFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'presentacion' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sumu'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sumd'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nombre'       => new sfValidatorPass(array('required' => false)),
      'presentacion' => new sfValidatorPass(array('required' => false)),
      'sumu'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sumd'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('partido_i18n_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidoI18n';
  }

  public function getFields()
  {
    return array(
      'id'           => 'ForeignKey',
      'culture'      => 'Text',
      'nombre'       => 'Text',
      'presentacion' => 'Text',
      'sumu'         => 'Number',
      'sumd'         => 'Number',
    );
  }
}

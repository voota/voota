<?php

/**
 * ConvocatoriaI18n filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseConvocatoriaI18nFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'descripcion' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'descripcion' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('convocatoria_i18n_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ConvocatoriaI18n';
  }

  public function getFields()
  {
    return array(
      'id'          => 'ForeignKey',
      'culture'     => 'Text',
      'descripcion' => 'Text',
    );
  }
}

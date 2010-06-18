<?php

/**
 * EtiquetaPropuesta filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEtiquetaPropuestaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('etiqueta_propuesta_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EtiquetaPropuesta';
  }

  public function getFields()
  {
    return array(
      'etiqueta_id'      => 'ForeignKey',
      'propuesta_id'     => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
    );
  }
}

<?php

/**
 * EtiquetaPartido filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseEtiquetaPartidoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('etiqueta_partido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EtiquetaPartido';
  }

  public function getFields()
  {
    return array(
      'etiqueta_id'      => 'ForeignKey',
      'partido_id'       => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
    );
  }
}

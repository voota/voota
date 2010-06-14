<?php

/**
 * EtiquetaPartido form base class.
 *
 * @method EtiquetaPartido getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEtiquetaPartidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'etiqueta_id' => new sfWidgetFormInputHidden(),
      'partido_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'etiqueta_id' => new sfValidatorPropelChoice(array('model' => 'Etiqueta', 'column' => 'id', 'required' => false)),
      'partido_id'  => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('etiqueta_partido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EtiquetaPartido';
  }


}

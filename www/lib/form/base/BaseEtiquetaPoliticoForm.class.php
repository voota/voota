<?php

/**
 * EtiquetaPolitico form base class.
 *
 * @method EtiquetaPolitico getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEtiquetaPoliticoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'etiqueta_id' => new sfWidgetFormInputHidden(),
      'politico_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'etiqueta_id' => new sfValidatorPropelChoice(array('model' => 'Etiqueta', 'column' => 'id', 'required' => false)),
      'politico_id' => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('etiqueta_politico[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EtiquetaPolitico';
  }


}

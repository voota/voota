<?php

/**
 * PartidoLista form base class.
 *
 * @method PartidoLista getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePartidoListaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'partido_id' => new sfWidgetFormInputHidden(),
      'lista_id'   => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'partido_id' => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'lista_id'   => new sfValidatorPropelChoice(array('model' => 'Lista', 'column' => 'id', 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('partido_lista[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PartidoLista';
  }


}

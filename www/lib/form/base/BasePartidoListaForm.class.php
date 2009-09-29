<?php

/**
 * PartidoLista form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePartidoListaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'partido_id' => new sfWidgetFormInputHidden(),
      'lista_id'   => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'partido_id' => new sfValidatorPropelChoice(array('model' => 'PartidoLista', 'column' => 'partido_id', 'required' => false)),
      'lista_id'   => new sfValidatorPropelChoice(array('model' => 'PartidoLista', 'column' => 'lista_id', 'required' => false)),
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

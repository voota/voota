<?php

/**
 * PoliticoLista form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoListaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'politico_id' => new sfWidgetFormInputHidden(),
      'lista_id'    => new sfWidgetFormInputHidden(),
      'orden'       => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'politico_id' => new sfValidatorPropelChoice(array('model' => 'PoliticoLista', 'column' => 'politico_id', 'required' => false)),
      'lista_id'    => new sfValidatorPropelChoice(array('model' => 'PoliticoLista', 'column' => 'lista_id', 'required' => false)),
      'orden'       => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_lista[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoLista';
  }


}

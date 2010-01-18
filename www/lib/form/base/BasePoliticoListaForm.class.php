<?php

/**
 * PoliticoLista form base class.
 *
 * @method PoliticoLista getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePoliticoListaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'politico_id' => new sfWidgetFormInputHidden(),
      'lista_id'    => new sfWidgetFormInputHidden(),
      'orden'       => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'politico_id' => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'lista_id'    => new sfValidatorPropelChoice(array('model' => 'Lista', 'column' => 'id', 'required' => false)),
      'orden'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
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

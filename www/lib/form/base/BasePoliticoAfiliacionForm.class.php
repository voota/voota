<?php

/**
 * PoliticoAfiliacion form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoAfiliacionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'politico_id'   => new sfWidgetFormInputHidden(),
      'afiliacion_id' => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'politico_id'   => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'afiliacion_id' => new sfValidatorPropelChoice(array('model' => 'Afiliacion', 'column' => 'id', 'required' => false)),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_afiliacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoAfiliacion';
  }


}

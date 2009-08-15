<?php

/**
 * PoliticoTemp form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePoliticoTempForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'     => new sfWidgetFormInput(),
      'partido'   => new sfWidgetFormInput(),
      'nombre'    => new sfWidgetFormInput(),
      'apellidos' => new sfWidgetFormInput(),
      'bio'       => new sfWidgetFormTextarea(),
      'id'        => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'email'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'partido'   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'apellidos' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'bio'       => new sfValidatorString(array('required' => false)),
      'id'        => new sfValidatorPropelChoice(array('model' => 'PoliticoTemp', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_temp[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoTemp';
  }


}

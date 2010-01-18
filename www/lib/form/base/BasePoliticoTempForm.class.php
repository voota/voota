<?php

/**
 * PoliticoTemp form base class.
 *
 * @method PoliticoTemp getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePoliticoTempForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'     => new sfWidgetFormInputText(),
      'partido'   => new sfWidgetFormInputText(),
      'nombre'    => new sfWidgetFormInputText(),
      'apellidos' => new sfWidgetFormInputText(),
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

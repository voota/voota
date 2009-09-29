<?php

/**
 * Partido form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BasePartidoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nombre'      => new sfWidgetFormInput(),
      'abreviatura' => new sfWidgetFormInput(),
      'color'       => new sfWidgetFormInput(),
      'web'         => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'partido_id'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 150)),
      'abreviatura' => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'color'       => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'web'         => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'partido_id'  => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Partido', 'column' => array('abreviatura')))
    );

    $this->widgetSchema->setNameFormat('partido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Partido';
  }


}

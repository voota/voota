<?php

/**
 * Opinion form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseOpinionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'valor'       => new sfWidgetFormInput(),
      'texto'       => new sfWidgetFormInput(),
      'usuario_id'  => new sfWidgetFormPropelChoice(array('model' => 'Usuario', 'add_empty' => false)),
      'partido_id'  => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id' => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'opinion_id'  => new sfWidgetFormPropelChoice(array('model' => 'Opinion', 'add_empty' => true)),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Opinion', 'column' => 'id', 'required' => false)),
      'valor'       => new sfValidatorInteger(array('required' => false)),
      'texto'       => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'usuario_id'  => new sfValidatorPropelChoice(array('model' => 'Usuario', 'column' => 'id')),
      'partido_id'  => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'politico_id' => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'opinion_id'  => new sfValidatorPropelChoice(array('model' => 'Opinion', 'column' => 'id', 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('opinion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Opinion';
  }


}

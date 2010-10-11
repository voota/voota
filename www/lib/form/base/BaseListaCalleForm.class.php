<?php

/**
 * ListaCalle form base class.
 *
 * @method ListaCalle getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseListaCalleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'convocatoria_id'    => new sfWidgetFormPropelChoice(array('model' => 'Convocatoria', 'add_empty' => false)),
      'partido_id'         => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => false)),
      'politico_id'        => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => false)),
      'circunscripcion_id' => new sfWidgetFormPropelChoice(array('model' => 'Circunscripcion', 'add_empty' => true)),
      'sumu'               => new sfWidgetFormInputText(),
      'sumd'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'ListaCalle', 'column' => 'id', 'required' => false)),
      'convocatoria_id'    => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id')),
      'partido_id'         => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id')),
      'politico_id'        => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id')),
      'circunscripcion_id' => new sfValidatorPropelChoice(array('model' => 'Circunscripcion', 'column' => 'id', 'required' => false)),
      'sumu'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'sumd'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'ListaCalle', 'column' => array('convocatoria_id', 'partido_id', 'politico_id', 'circunscripcion_id')))
    );

    $this->widgetSchema->setNameFormat('lista_calle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaCalle';
  }


}

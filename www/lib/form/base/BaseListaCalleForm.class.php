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
      'convocatoria_id' => new sfWidgetFormInputHidden(),
      'partido_id'      => new sfWidgetFormInputHidden(),
      'geo_id'          => new sfWidgetFormInputHidden(),
      'politico_id'     => new sfWidgetFormInputHidden(),
      'min_sumu'        => new sfWidgetFormInputText(),
      'min_sumd'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'convocatoria_id' => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id', 'required' => false)),
      'partido_id'      => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'geo_id'          => new sfValidatorPropelChoice(array('model' => 'Geo', 'column' => 'id', 'required' => false)),
      'politico_id'     => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'min_sumu'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'min_sumd'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('lista_calle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaCalle';
  }


}

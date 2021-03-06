<?php

/**
 * EtiquetaPropuesta form base class.
 *
 * @method EtiquetaPropuesta getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEtiquetaPropuestaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'etiqueta_id'      => new sfWidgetFormInputHidden(),
      'propuesta_id'     => new sfWidgetFormInputHidden(),
      'culture'          => new sfWidgetFormInputHidden(),
      'sf_guard_user_id' => new sfWidgetFormInputHidden(),
      'fecha'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'etiqueta_id'      => new sfValidatorPropelChoice(array('model' => 'Etiqueta', 'column' => 'id', 'required' => false)),
      'propuesta_id'     => new sfValidatorPropelChoice(array('model' => 'Propuesta', 'column' => 'id', 'required' => false)),
      'culture'          => new sfValidatorPropelChoice(array('model' => 'EtiquetaPropuesta', 'column' => 'culture', 'required' => false)),
      'sf_guard_user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'fecha'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('etiqueta_propuesta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EtiquetaPropuesta';
  }


}

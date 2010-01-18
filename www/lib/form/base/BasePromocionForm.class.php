<?php

/**
 * Promocion form base class.
 *
 * @method Promocion getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePromocionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'fecha_inicio' => new sfWidgetFormDate(),
      'fecha_fin'    => new sfWidgetFormDate(),
      'partido_id'   => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => true)),
      'politico_id'  => new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true)),
      'created_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Promocion', 'column' => 'id', 'required' => false)),
      'fecha_inicio' => new sfValidatorDate(),
      'fecha_fin'    => new sfValidatorDate(),
      'partido_id'   => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id', 'required' => false)),
      'politico_id'  => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('promocion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Promocion';
  }


}

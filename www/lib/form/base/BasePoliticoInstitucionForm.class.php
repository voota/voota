<?php

/**
 * PoliticoInstitucion form base class.
 *
 * @method PoliticoInstitucion getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePoliticoInstitucionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'politico_id'    => new sfWidgetFormInputHidden(),
      'institucion_id' => new sfWidgetFormInputHidden(),
      'fecha_inicio'   => new sfWidgetFormDate(),
      'fecha_fin'      => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'politico_id'    => new sfValidatorPropelChoice(array('model' => 'Politico', 'column' => 'id', 'required' => false)),
      'institucion_id' => new sfValidatorPropelChoice(array('model' => 'Institucion', 'column' => 'id', 'required' => false)),
      'fecha_inicio'   => new sfValidatorDate(array('required' => false)),
      'fecha_fin'      => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('politico_institucion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PoliticoInstitucion';
  }


}

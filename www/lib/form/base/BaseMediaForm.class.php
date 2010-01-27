<?php

/**
 * Media form base class.
 *
 * @method Media getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseMediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmedia'    => new sfWidgetFormInputHidden(),
      'tipo'       => new sfWidgetFormInputText(),
      'idpolitico' => new sfWidgetFormInputText(),
      'idpartido'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idmedia'    => new sfValidatorPropelChoice(array('model' => 'Media', 'column' => 'idmedia', 'required' => false)),
      'tipo'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'idpolitico' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'idpartido'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('media[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Media';
  }


}

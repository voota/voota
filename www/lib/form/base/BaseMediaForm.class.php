<?php

/**
 * Media form base class.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseMediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idmedia'    => new sfWidgetFormInputHidden(),
      'tipo'       => new sfWidgetFormInput(),
      'idpolitico' => new sfWidgetFormInput(),
      'idpartido'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'idmedia'    => new sfValidatorPropelChoice(array('model' => 'Media', 'column' => 'idmedia', 'required' => false)),
      'tipo'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'idpolitico' => new sfValidatorInteger(array('required' => false)),
      'idpartido'  => new sfValidatorInteger(array('required' => false)),
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

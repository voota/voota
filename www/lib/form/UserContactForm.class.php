<?php
class UserContactForm extends sfVoForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'mensaje'   => new sfWidgetFormTextarea(array()),
    ));
    $this->widgetSchema->setNameFormat('contact[%s]');
	$this->setValidators(array(
      'mensaje'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
	));
   
  }
}
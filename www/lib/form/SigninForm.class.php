<?php

class SigninForm extends sfVoForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInput(array()),
      'password' => new sfWidgetFormInput(array('type' => 'password')),
      'remember' => new sfWidgetFormInputCheckbox(array(), array()),
    ));
	$this->widgetSchema->setLabels(array(
  	  'username'    => 'Email',
	  'password'    => sfContext::getInstance()->getI18N()->__('Password', array(), 'notices'),
	  'remember'    => sfContext::getInstance()->getI18N()->__('Recordar', array(), 'notices'),
	)); 
        $this->setValidators(array(
      'username'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
      'password' => new sfValidatorPassword(array('required' => true), sfVoForm::getStringMessages()),
      'remember' => new sfValidatorBoolean(),
    ));

    //$this->validatorSchema->setPostValidator(new sfGuardValidatorUser(array(), sfVoForm::getUserMessages()));

    $this->widgetSchema->setNameFormat('signin[%s]');
  }
  
  public function addPostValidation() {
  	$this->validatorSchema->setPostValidator(new sfGuardValidatorUser(array(), sfVoForm::getUserMessages()));
  }
}

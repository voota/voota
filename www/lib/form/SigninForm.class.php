<?php

class SigninForm extends sfVoForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'password' => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
      'remember' => new sfWidgetFormInputCheckbox(array(), array('class' => 'inputSign')),
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

    $this->validatorSchema->setPostValidator(new sfGuardValidatorUser(array(), sfVoForm::getUserMessages()));

    $this->widgetSchema->setNameFormat('signin[%s]');
  }
}

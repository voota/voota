<?php
class PasswordChangeForm extends sfForm
{
 
  public function configure()
  {
	$years = range(1920,date('Y'));
	
    $this->setWidgets(array(
	  'password'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
    'password_again'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('changer[%s]');
 	$this->widgetSchema->setLabels(array(
	  'password'    => sfContext::getInstance()->getI18N()->__('Password', array(), 'notices'),
 	  'password_again'    => sfContext::getInstance()->getI18N()->__('Password (otra vez)', array(), 'notices'),
	)); 
    
    $this->setValidators(array(
      'password'    => new sfValidatorPassword(array('required' => true, ), sfVoForm::getStringMessages()),
      'password_again'    => new sfValidatorPassword(array('required' => true, ), sfVoForm::getStringMessages()),
       ));
       
	
    $this->validatorSchema->setPostValidator(
    	new sfValidatorSchemaCompare('password',  sfValidatorSchemaCompare::EQUAL, 'password_again',  array(), sfVoForm::getCompareMessages())
    );
	
  }
}
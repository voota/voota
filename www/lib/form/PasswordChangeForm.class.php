<?php
class PasswordChangeForm extends BaseForm
{
 
  public function configure()
  {
	$years = range(1920,date('Y'));
	
    $this->setWidgets(array(
	  'passwordNew'  => new sfWidgetFormInputText(array('type' => 'password')),
      'password_again'  => new sfWidgetFormInputText(array('type' => 'password')),
    ));
    $this->widgetSchema->setNameFormat('changer[%s]');
 	$this->widgetSchema->setLabels(array(
	  'passwordNew'    => sfContext::getInstance()->getI18N()->__('Password', array(), 'notices'),
 	  'password_again'    => sfContext::getInstance()->getI18N()->__('Password (otra vez)', array(), 'notices'),
	)); 
    
    $this->setValidators(array(
      'passwordNew'    => new sfValidatorPassword(array('required' => true, ), sfVoForm::getStringMessages()),
      'password_again'    => new sfValidatorPassword(array('required' => true, ), sfVoForm::getStringMessages()),
       ));
       
	
    $this->validatorSchema->setPostValidator(
    	new sfValidatorSchemaCompare('passwordNew',  sfValidatorSchemaCompare::EQUAL, 'password_again',  array(), sfVoForm::getCompareMessages())
    );
	
  }
}
<?php
class RegistrationForm extends sfVoForm
{
 
  public function configure()
  {
    $this->setWidgets(array(
      'op' => new sfWidgetFormInputHidden(),
      'username'   => new sfWidgetFormInputText(array()),
      'nombre'   => new sfWidgetFormInputText(array()),
      'apellidos'   => new sfWidgetFormInputText(array()),
      'password' => new sfWidgetFormInputText(array('type' => 'password'), array('autocomplete' => 'off')),
      'accept' => new sfWidgetFormInputCheckbox(array(), array()),
    ));
    $this->widgetSchema->setNameFormat('registration[%s]');
	$this->widgetSchema->setLabels(array(
  	  'username'    => 'Email',
	  'nombre'    => sfContext::getInstance()->getI18N()->__('Nombre', array(), 'notices'),
	  'apellidos'    => sfContext::getInstance()->getI18N()->__('Apellidos', array(), 'notices'),
	'password'    => sfContext::getInstance()->getI18N()->__('Password', array(), 'notices'),
	)); 
	$this->setValidators(array(
      'op'    => new sfValidatorString(array('required' => false)),    
      'username'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
      'nombre'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
      'apellidos'   => new sfValidatorString(array('required' => false), sfVoForm::getStringMessages()),    
      'password'    => new sfValidatorPassword(array('required' => true), sfVoForm::getStringMessages()),
      'accept' => new sfValidatorBoolean(array('required' => true), sfVoForm::getRequiredMessages()),
    ));
    
    //$this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username'))));
    $this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username')), sfVoForm::getUniqueEmailMessages()));
    
  }
}
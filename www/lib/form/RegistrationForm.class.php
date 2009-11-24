<?php
class RegistrationForm extends sfVoForm
{
 
  public function configure()
  {
    $this->setWidgets(array(
      'op' => new sfWidgetFormInputHidden(),
      'username'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'nombre'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'apellidos'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'password' => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign', 'autocomplete' => 'off')),
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
    ));
    
    //$this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username'))));
    $this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username')), sfVoForm::getUniqueEmailMessages()));
    
  }
}
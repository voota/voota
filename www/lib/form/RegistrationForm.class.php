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
      'password' => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('registration[%s]');
	$this->widgetSchema->setLabels(array(
	  'username'    => 'Email',
	  'apellidos'    => 'Apellidos',
	  'password'    => 'Password',
	));
    $this->setValidators(array(
      'op'    => new sfValidatorString(array('required' => false)),    
      'username'   => new sfValidatorAnd(array(
    	new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),  
        new sfValidatorEmail(array(), sfVoForm::getEmailMessages()),  
        //new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => 'username'), array('invalid' => 'name in use')),
       )),
      'nombre'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
      'apellidos'   => new sfValidatorString(array('required' => false), sfVoForm::getStringMessages()),    
      'password'    => new sfValidatorPassword(array('required' => true), sfVoForm::getStringMessages()),
    ));
    
    //$this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username'))));
    $this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username')), sfVoForm::getUniqueMessages()));
    
  }
}
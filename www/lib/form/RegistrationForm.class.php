<?php
class RegistrationForm extends sfForm
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
 
    $this->setValidators(array(
      'op'    => new sfValidatorString(array('required' => false)),    
      'username'   => new sfValidatorAnd(array(
    	new sfValidatorString(array('required' => true)),  
        new sfValidatorEmail(),  
        //new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => 'username'), array('invalid' => 'name in use')),
       )),
      'nombre'   => new sfValidatorString(array('required' => true)),      
      'apellidos'   => new sfValidatorString(array('required' => false)),    
      'password'    => new sfValidatorString(array('required' => true)),
    ));
    
    //$this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username'))));
    $this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model'=>'sfGuardUser', 'column'=>array('username'))));
    
  }
}
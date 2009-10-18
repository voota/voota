<?php
class PasswordChangeForm extends sfForm
{
 
  public function configure()
  {
	$years = range(1920,date('Y'));
	
    $this->setWidgets(array(
	  'codigo'  => new sfWidgetFormInputHidden(array()),
	  'password'  => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
    'password_again'  => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('changer[%s]');
 
    $this->setValidators(array(
      'codigo'    => new sfValidatorString(array('required' => true)),
      'password'    => new sfValidatorString(array('required' => false)),
    'password_again'    => new sfValidatorString(array('required' => false)),
       ));
       
	
	
  }
}
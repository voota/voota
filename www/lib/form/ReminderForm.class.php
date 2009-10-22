<?php
class ReminderForm extends sfForm
{
 
  public function configure()
  {
    $this->setWidgets(array(
      'username'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('reminder[%s]');
 
    $this->setValidators(array(
      'username'   => new sfValidatorAnd(array(
    	new sfValidatorString(array('required' => true)),  
        new sfValidatorEmail(array(), sfVoForm::$messagesEmail),  
        //new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => 'username'), array('invalid' => 'name in use')),
       )),
    ));
    
  }
}
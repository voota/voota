<?php
class ReminderForm extends BaseForm
{
 
  public function configure()
  {
    $this->setWidgets(array(
      'username'   => new sfWidgetFormInputText(array()),
    ));
    $this->widgetSchema->setNameFormat('reminder[%s]');
	$this->widgetSchema->setLabels(array(
  	  'username'    => 'Email',
	)); 
        
    $this->setValidators(array(
      'username'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
    ));
    
  }
}
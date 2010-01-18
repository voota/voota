<?php
class ContactForm extends sfVoForm
{
  protected static $tipos = array('Sugerencia' => 'Sugerencia', 'Problema' => 'Problema');
 
  public function configure()
  {
    $this->setWidgets(array(
      'nombre'   => new sfWidgetFormInputText(array()),
      'email'   => new sfWidgetFormInputText(array()),
      'tipo'   => new sfWidgetFormSelect(array('choices' => self::$tipos)),
      'mensaje'   => new sfWidgetFormTextarea(array()),
    ));
    $this->widgetSchema->setNameFormat('contact[%s]');
	$this->setValidators(array(
      'nombre'   => new sfValidatorString(array('required' => false), sfVoForm::getStringMessages()),      
      'email'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
      'tipo'   => new sfValidatorString(array('required' => false), sfVoForm::getStringMessages()),    
      'mensaje'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
	));
   
  }
}
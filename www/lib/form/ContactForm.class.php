<?php
class ContactForm extends sfVoForm
{
  protected static $tipos = array('Sugerencia' => 'Sugerencia', 'Problema' => 'Problema');
  
  var $mensajeWidget;
  public function setDefaultMsg($str){
  	$this->mensajeWidget->setDefault( "$str" );
  	$this->configure();
  } 
 
  public function configure()
  {
  	if (!$this->mensajeWidget){
  		$this->mensajeWidget = new sfWidgetFormTextarea(array());
  	} 
  	
    $this->setWidgets(array(
      'nombre'   => new sfWidgetFormInputText(array()),
      'email'   => new sfWidgetFormInputText(array()),
      'tipo'   => new sfWidgetFormSelect(array('choices' => self::$tipos)),
      'mensaje'   => $this->mensajeWidget,
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
<?php
class PreviewPropuestaForm extends PropuestaForm
{
	
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		$taintedValues['sf_guard_user_id'] = sfContext::getInstance()->getUser()->getGuardUser()->getId();

		parent::bind($taintedValues, $taintedFiles);
	}
	
	
  public function configure()
  {
  	unset(
  		$this['id']
  		, $this['vanity']
  	);
  	
    $this->setWidgets(array(
      'op' => new sfWidgetFormInputHidden(),
      'titulo'   => new sfWidgetFormInputHidden(array()),
      'descripcion'   => new sfWidgetFormInputHidden(array()),
      'imagen'   => new sfWidgetFormInputHidden(),
      'doc'   => new sfWidgetFormInputHidden()
	)); 
    $this->widgetSchema->setNameFormat('propuesta[%s]');
	
    
  }
}
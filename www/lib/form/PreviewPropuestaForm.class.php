<?php
class PreviewPropuestaForm extends PropuestaForm
{
	
	public function bind(array $taintedValues = null, array $taintedFiles = null, $imageName = false, $docName = false) {
		if ($imageName)
			$taintedValues['imagen'] = $imageName;
		if ($docName)
			$taintedValues['doc'] = $docName;
			
		$taintedValues['sf_guard_user_id'] = sfContext::getInstance()->getUser()->getGuardUser()->getId();
		$taintedValues['culture'] = sfContext::getInstance()->getUser()->getCulture();

		parent::bind($taintedValues, $taintedFiles);
	}
	
	
  public function configure()
  {
  	unset(
  		$this['sumu']
  		, $this['sumd']
  		, $this['created_at']
  		, $this['modified_at']
  		, $this['id']
  		, $this['vanity']
  	);
  	
    $this->setWidgets(array(
      'op' => new sfWidgetFormInputHidden(),
      'titulo'   => new sfWidgetFormInputHidden(array()),
      'descripcion'   => new sfWidgetFormInputHidden(array()),
      'imagen'   => new sfWidgetFormInputHidden(array()),
      'doc'   => new sfWidgetFormInputHidden(array())
	)); 
    $this->widgetSchema->setNameFormat('propuesta[%s]');
	$this->setValidators(array(
      'titulo'   => new sfValidatorString(array("min_length" => SfVoUtil::VANITY_MIN_LENGTH, 'required' => true), sfVoForm::getStringMessages()),  
      'descripcion'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),
      'vanity'   => new sfValidatorString(array('required' => true)),
      'sf_guard_user_id'   => new sfValidatorInteger(array('required' => true)),
      'imagen'   => new sfValidatorString(array('required' => false)),
      'doc'   => new sfValidatorString(array('required' => false)),
      'culture'   => new sfValidatorFile(array('required' => false))
    ));
	
    
  }
}
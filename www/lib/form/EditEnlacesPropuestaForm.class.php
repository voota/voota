<?php
class EditEnlacesPropuestaForm extends BasePropuestaForm
{
	
	public function bind(array $taintedValues = null, array $taintedFiles = null) {		
		for ($idx = 1;$idx <= 5;$idx++){
			$this->validatorSchema["enlace_n$idx"]['url'] = new sfVoValidatorUrl(array('required' => false), sfVoForm::getUrlMessages());
			$this->validatorSchema["enlace_n$idx"]['culture'] = new sfValidatorString(array('required' => false));
			
			if (is_null($taintedValues["enlace_n$idx"]['url'])) {
				unset($this->embeddedForms["enlace_n$idx"], $taintedValues["enlace_n$idx"]);
			} else {
				$enlace = $this->embeddedForms["enlace_n$idx"]->getObject();
				
				$taintedValues["enlace_n$idx"]['culture'] = sfContext::getInstance()->getUser()->getCulture();
			}
		}
		
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
  		, $this['sf_guard_user_id']
  		, $this['titulo']
  		, $this['descripcion']
  		, $this['imagen']
  		, $this['doc']
  	);
  	
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden()
    ));
    
    $this->widgetSchema->setNameFormat('propuesta[%s]');

		// embed all enlace forms
		$idx = 0;
		foreach ($this->getObject()->getEnlaces() as $enlace) {
			$idx++;
	   		// create a new enlace form for the current enlace model object
			$enlaceForm = new PropuestaEnlaceForm( $enlace );
			// embed the enlace form in the main politico form
			$this->embedForm("enlace_n$idx", $enlaceForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema["enlace_n$idx"]->setLabel('Enlace '.$enlace->getId());

			// change the name widget to sfWidgetFormInputDelete
			$this->widgetSchema["enlace_n$idx"]['url'] = new sfWidgetFormInputText(array());
			$this->widgetSchema["enlace_n$idx"]['orden'] = new sfWidgetFormInputHidden();
			$this->widgetSchema["enlace_n$idx"]['culture'] = new sfWidgetFormInputHidden();
		}

		// Vacíos
		while ($idx < 5){
			$idx++;
			// create a new enlace form for a new enlace model object
			$enlaceForm = new PropuestaEnlaceForm();
	
			// embed the enlace form in the main politico form
			$this->embedForm("enlace_n$idx", $enlaceForm);
			$this->widgetSchema["enlace_n$idx"]['orden'] = new sfWidgetFormInputHidden();
			
			// set a custom label for the embedded form
			$this->widgetSchema["enlace_n$idx"]->setLabel('Nuevo enlace');
		}
	
  }
}
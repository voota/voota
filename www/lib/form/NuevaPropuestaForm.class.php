<?php
class NuevaPropuestaForm extends PropuestaForm
{
	
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		$taintedValues['sf_guard_user_id'] = sfContext::getInstance()->getUser()->getGuardUser()->getId();
		
		for ($idx = 1;$idx <= 5;$idx++){
			if (is_null($taintedValues["enlace_n$idx"]['url'])) {
		
				unset($this->embeddedForms["enlace_n$idx"], $taintedValues["enlace_n$idx"]);
		
				$this->validatorSchema["enlace_n$idx"]['url'] = new sfValidatorUrl(array('required' => false));
		
			} else {
				$this->validatorSchema["enlace_n$idx"]['url'] = new sfVoValidatorUrl(array('required' => false), sfVoForm::getUrlMessages());
				$this->embeddedForms["enlace_n$idx"]->getObject()->setPropuesta($this->getObject());
		
			}
		}
		
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
      'titulo'   => new sfWidgetFormTextArea(array()),
      'descripcion'   => new sfWidgetFormTextArea(array(), array('rows'=>20,'cols'=>30)),
      'imagen'   => new sfWidgetFormInputFileEditable(array(
			   'label'     => sfContext::getInstance()->getI18N()->__('Imagen', array(), 'notices'),
   			 'file_src'  => $this->getObject()?''.S3Voota::getImagesUrl().'/usuarios/cc_s_'.$this->getObject()->getImagen():'',
			   'is_image'  => false,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '<div>' . ($this->getObject()->getImagen()?'<p><img src="%file%" alt="'.$this->getObject()->getTitulo().'" /> %delete% <label for="profile_imagen_delete">'. sfContext::getInstance()->getI18N()->__('Eliminar imagen actual', array(), 'notices') .'</label></p>':'') . '%input% <span class="hints">' . sfContext::getInstance()->getI18N()->__('(opcional)') . '</span></div>'
				)),
      'doc'   => new sfWidgetFormInputFileEditable(array(
			   'label'     => sfContext::getInstance()->getI18N()->__('Imagen', array(), 'notices'),
   			   'file_src'  => $this->getObject()?''.S3Voota::getImagesUrl().'/usuarios/cc_s_'.$this->getObject()->getDoc():'',
			   'is_image'  => false,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '<div>' . ($this->getObject()->getImagen()?'<p>'.$this->getObject()->getTitulo().' %delete% <label for="profile_imagen_delete">'. sfContext::getInstance()->getI18N()->__('Eliminar documento actual', array(), 'notices') .'</label></p>':'') . '%input% <span class="hints">' . sfContext::getInstance()->getI18N()->__('(opcional)') . '</span></div>'
				)),
    ));
    $this->widgetSchema->setNameFormat('propuesta[%s]');
	$this->widgetSchema->setLabels(array(
	  'titulo'    => sfContext::getInstance()->getI18N()->__('Título', array(), 'notices'),
	  'descripcion'    => sfContext::getInstance()->getI18N()->__('Descripción', array(), 'notices'),
	)); 
	$this->setValidators(array(
      'titulo'   => new sfValidatorString(array("min_length" => SfVoUtil::VANITY_MIN_LENGTH, 'required' => true), sfVoForm::getStringMessages()),  
      'descripcion'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),
      'vanity'   => new sfValidatorString(array('required' => true)),
      'sf_guard_user_id'   => new sfValidatorInteger(array('required' => true)),
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/propuestas',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
      'doc'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '2048000',
				   'path' => sfConfig::get('sf_upload_dir').'/docs',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
    ));
    
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Propuesta', 'column' => array('vanity')), sfVoForm::getUniqueMessages()),
        new sfValidatorPropelUnique(array('model' => 'Propuesta', 'column' => array('titulo')), sfVoForm::getUniqueMessages()),
      ))
    );
    
  
		// Vacíos
		$idx = 0;
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
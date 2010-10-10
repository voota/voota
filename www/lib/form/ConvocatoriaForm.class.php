<?php

/**
 * Convocatoria form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class ConvocatoriaForm extends BaseConvocatoriaForm
{
  public function configure()
  {
  	unset(
  		$this['created_at'],
  		$this['total_escanyos'],
  		$this['min_sumu'],
  		$this['min_sumd'],
  		$this['lista_calle_list']
  	);
  	
    $this->embedI18n(array('es', 'ca'));
  	
	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
	   'label'     => 'Imagen Principal',
	   'file_src'  => S3Voota::getImagesUrl().'/elecciones/cc_'.$this->getObject()->getImagen(),
	   'is_image'  => true,
	   'edit_mode' => !$this->isNew(),
	   'template'  => '<div>%file% <br /> %input%<br />%delete% Eliminar imagen actual</div>',
	));
	
    $this->validatorSchema['imagen'] = new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/elecciones',
				   'validated_file_class' => 'sfResizedFile',
	), sfVoForm::getImageMessages("500K"));
	$this->validatorSchema['imagen_delete'] = new sfValidatorBoolean();
	
	
  	if (!$this->isNew()) {
		// embed all enlace forms
		foreach ($this->getObject()->getEnlaces() as $enlace) {
	   		// create a new enlace form for the current enlace model object
			$enlaceForm = new ConvocatoriaEnlaceForm( $enlace );
			// embed the enlace form in the main Eleccion form
			$this->embedForm('enlace'.$enlace->getId(), $enlaceForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema['enlace'.$enlace->getId()]->setLabel('Enlace '.$enlace->getId());

			// change the name widget to sfWidgetFormInputDelete
			$this->widgetSchema['enlace'.$enlace->getId()]['url'] = new sfWidgetFormInputDelete(array(
				'url' => 'convocatoria/deleteEnlace',      // required
				'model_id' => $enlace->getId(),        // required
				'confirm' => 'Sure???',                     // optional
			));
		}

		// create a new enlace form for a new enlace model object
		$enlaceForm = new ConvocatoriaEnlaceForm();

		// embed the enlace form in the main convocatoria form
		$this->embedForm('enlace', $enlaceForm);

		// set a custom label for the embedded form
		$this->widgetSchema['enlace']->setLabel('Nuevo enlace');
    }
  }
  
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		if (!$this->isNew()) {
			if (is_null($taintedValues['enlace']['url']) || strlen($taintedValues['enlace']['url']) === 0 ) {
				unset($this->embeddedForms['enlace'], $taintedValues['enlace']);
		
				$this->validatorSchema['enlace'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['enlace']->getObject()->setConvocatoria($this->getObject());
			}
		}	
		parent::bind($taintedValues, $taintedFiles);
	}
}

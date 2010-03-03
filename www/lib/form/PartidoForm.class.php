<?php

/**
 * Partido form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PartidoForm extends BasePartidoForm
{	
  protected function processUploadedFile($field, $filename = null, $values = null)
  {
  	  $column = call_user_func(array(constant(get_class($this->getObject()).'::PEER'), 'translateFieldName'), $field, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
      $getter = 'get'.$column;

      return $this->getObject()->$getter();
  }
  
  public function configure()
  {
  	unset(
  		$this['partido_lista_list']
  		, $this['created_at']
  		, $this['partido_id']
    	, $this['sumu']
    	, $this['sumd']  
    	, $this['sumd']   		  		
  	);
    
    
    $this->embedI18n(array('es', 'ca'));
    
    $this->widgetSchema['sumu'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['sumd'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
   'label'     => 'Imagen Principal',
   'file_src'  => S3Voota::getImagesUrl().'/partidos/cc_s_'.$this->getObject()->getImagen(),
   'is_image'  => true,
   'edit_mode' => !$this->isNew(),
   'template'  => '<div>%file% <label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
	));
	
	$this->validatorSchema['imagen'] = new sfValidatorFile(array(
   'required'   => false,
   'mime_types' => 'web_images',
	'path' => sfConfig::get('sf_upload_dir').'/partidos',
   'validated_file_class' => 'sfResizedFile',
	));
    $this->validatorSchema['sumu'] = new sfValidatorString(array('required' => true));  
    $this->validatorSchema['sumd'] = new sfValidatorString(array('required' => true));  
  
	if (!$this->isNew()) {
		// embed all enlace forms
		foreach ($this->getObject()->getEnlaces() as $enlace) {
	   		// create a new enlace form for the current enlace model object
			$enlaceForm = new PartidoEnlaceForm( $enlace );
			// embed the enlace form in the main partido form
			$this->embedForm('enlace'.$enlace->getId(), $enlaceForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema['enlace'.$enlace->getId()]->setLabel('Enlace '.$enlace->getId());

			// change the name widget to sfWidgetFormInputDelete
			$this->widgetSchema['enlace'.$enlace->getId()]['url'] = new sfWidgetFormInputDelete(array(
				'url' => 'partido/deleteEnlace',      // required
				'model_id' => $enlace->getId(),        // required
				'confirm' => 'Sure???',                     // optional
			));
		}

		// create a new enlace form for a new enlace model object
		$enlaceForm = new PartidoEnlaceForm();

		// embed the enlace form in the main partido form
		$this->embedForm('enlace', $enlaceForm);

		// set a custom label for the embedded form
		$this->widgetSchema['enlace']->setLabel('Nuevo enlace');
	}
	$this->validatorSchema['imagen_delete'] = new sfValidatorBoolean();
 }
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		if (!$this->isNew()) {
			if (is_null($taintedValues['enlace']['url']) || strlen($taintedValues['enlace']['url']) === 0 ) {
				unset($this->embeddedForms['enlace'], $taintedValues['enlace']);
		
				$this->validatorSchema['enlace'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['enlace']->getObject()->
		                setPartido($this->getObject());
			}
		}	
		parent::bind($taintedValues, $taintedFiles);
	}
}
  
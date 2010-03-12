<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class PoliticoForm extends BasePoliticoForm
{
  protected static $generos = array('N' => '?', 'H' => 'Hombre', 'M' => 'Mujer');
  protected static $relaciones = array(
  									'N' => '?',
  									'SO' => 'Soltero/a',
								    'RE' => 'En una relación',
								    'CO' => 'Comprometido/a',
								    'CA' => 'Casado/a',
								    'DI' => 'Divorciado/a',
								    'ES' => 'Es complicado',
								    'RA' => 'En una relación abierta',
								    'VI' => 'Viudo(a)',
								 );

  

  protected function processUploadedFile($field, $filename = null, $values = null)
  {
  	  $column = call_user_func(array(constant(get_class($this->getObject()).'::PEER'), 'translateFieldName'), $field, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
      $getter = 'get'.$column;

      return $this->getObject()->$getter();
  }

  public function configure()
  {
  	unset(
  		$this['politico_lista_list']
  		, $this['pais']
  		, $this['created_at']
  		, $this['partido_txt']
  		, $this['sumu']
  		, $this['sumd']
  		, $this['politico_institucion_list']
  		, $this['sf_guard_user_id']
  	);
    
	$this->widgetSchema['sf_guard_user_profile_id'] = new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Institucion',
	      'url'   => $this->getOption('url')
	    )
	));
    
    $this->embedI18n(array('es', 'ca'));
    
  	
    $this->widgetSchema['sexo'] = new sfWidgetFormSelect(array('choices' => self::$generos));
    $this->widgetSchema['relacion'] = new sfWidgetFormSelect(array('choices' => self::$relaciones));
    
    $years = range(1920,date('Y'));
    $this->widgetSchema['fecha_nacimiento'] = new sfWidgetFormJQueryDate(array(
    						'culture' => 'es'
    							, 'format' => '%day%/%month%/%year%'
    							, 'years' => array_combine($years, $years)
    						));

	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
   'label'     => 'Imagen Principal',
   'file_src'  => S3Voota::getImagesUrl().'/politicos/cc_'.$this->getObject()->getImagen(),
   'is_image'  => true,
   'edit_mode' => !$this->isNew(),
   'template'  => '<div>%file%  <img src="'.S3Voota::getImagesUrl().'/politicos/bw_'.$this->getObject()->getImagen().'"><br /><label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
	));
	
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));  
	$this->validatorSchema['imagen'] = new sfValidatorFile(array(
   'required'   => false,
   'mime_types' => 'web_images',
	'path' => sfConfig::get('sf_upload_dir').'/politicos',
   'validated_file_class' => 'sfResizedFile',
	));
  	
	if (!$this->isNew()) {
		// embed all enlace forms
		foreach ($this->getObject()->getEnlaces() as $enlace) {
	   		// create a new enlace form for the current enlace model object
			$enlaceForm = new PoliticoEnlaceForm( $enlace );
			// embed the enlace form in the main politico form
			$this->embedForm('enlace'.$enlace->getId(), $enlaceForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema['enlace'.$enlace->getId()]->setLabel('Enlace '.$enlace->getId());

			// change the name widget to sfWidgetFormInputDelete
			$this->widgetSchema['enlace'.$enlace->getId()]['url'] = new sfWidgetFormInputDelete(array(
				'url' => 'politico/deleteEnlace',      // required
				'model_id' => $enlace->getId(),        // required
				'confirm' => 'Sure???',                     // optional
			));
		}

		// create a new enlace form for a new enlace model object
		$enlaceForm = new PoliticoEnlaceForm();

		// embed the enlace form in the main politico form
		$this->embedForm('enlace', $enlaceForm);

		// set a custom label for the embedded form
		$this->widgetSchema['enlace']->setLabel('Nuevo enlace');
	}	
	
	if (!$this->isNew()) {
		// embed all institucion forms
		foreach ($this->getObject()->getPoliticoInstitucions() as $institucion) {
	   		// create a new insti form for the current insti model object
			$institucionForm = new PoliticoInstitucionForm( $institucion );
			$institucionForm->setOption('url', $this->getOption('url'));
			$institucionForm->configure();
			
			// embed the institucion form in the main politico form
			$this->embedForm('institucion'.$institucion->getInstitucion()->getId(), $institucionForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema['institucion'.$institucion->getInstitucion()->getId()]->setLabel('Institucion '.$institucion->getInstitucion()->getId());

			// change the name widget to sfWidgetFormInputDelete
			/*
			$this->widgetSchema['institucion'.$institucion->getInstitucion()->getId()]['url'] = new sfWidgetFormInputDelete(array(
				'url' => 'politico/deleteInstitucion',      // required
				'model_id' => $institucion->getInstitucion()->getId(),        // required
				'confirm' => 'Sure???',                     // optional
			));
			*/
		}

		// create a new institucion form for a new institucion model object
		$politicoInstitucion = new PoliticoInstitucion();
		$politicoInstitucion->setPoliticoId( $this->getObject()->getId() );
		$institucionForm = new PoliticoInstitucionForm( $politicoInstitucion );
		$institucionForm->setOption('url', $this->getOption('url'));
		$institucionForm->configure();

		// embed the institucion form in the main politico form
		$this->embedForm('institucion', $institucionForm);

		// set a custom label for the embedded form
		$this->widgetSchema['institucion']->setLabel('Nueva institución');
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
		                setPolitico($this->getObject());
			}
			
		
			if (is_null($taintedValues['institucion']['institucion_id']) || strlen($taintedValues['institucion']['institucion_id']) === 0 ) {
				unset($this->embeddedForms['institucion'], $taintedValues['institucion']);
		
				$this->validatorSchema['institucion'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['institucion']->getObject()->
		                setPolitico($this->getObject());
			}
		}	
		parent::bind($taintedValues, $taintedFiles);
	}
}

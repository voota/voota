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

  
  

  public function configure()
  {
  	unset(
  		$this['politico_lista_list']
  		, $this['pais']
  		, $this['created_at']
  		, $this['partido_txt']
  		, $this['sumu']
  		, $this['sumd']
  		, $this['sf_guard_user_profile_id']
  		, $this['politico_institucion_list']
  	);
    
    
    
    $this->embedI18n(array('es', 'ca'));
    
  	
    $this->widgetSchema['sumu'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['sumd'] = new sfWidgetFormInputHidden();
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
   'file_src'  => 'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_'.$this->getObject()->getImagen(),
   'is_image'  => true,
   'edit_mode' => !$this->isNew(),
   'template'  => '<div>%file%  <img src="https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/bw_'.$this->getObject()->getImagen().'"><br /><label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
	));
	
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));  
    $this->validatorSchema['sumu'] = new sfValidatorString(array('required' => true));  
    $this->validatorSchema['sumd'] = new sfValidatorString(array('required' => true));  
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
		}	
		parent::bind($taintedValues, $taintedFiles);
	}
}

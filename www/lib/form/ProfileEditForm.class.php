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
class ProfileEditForm extends sfGuardUserAdminForm
{
  public function setImageSrc( $imagen ){
  	$options = $this->widgetSchema['imagen']->getOptions();
  	$options['file_src'] = $this->getObject()->getProfile()->getImagen()?'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.$imagen:'';
  	$this->widgetSchema['imagen']->setOptions( $options );
  	$this->values['imagen'] = $imagen;
  }
  
  public function configure()
  {
	$years = range(1920,date('Y'));
	
    $this->setWidgets(array(
      'fecha_nacimiento'   => new sfWidgetFormDate(array(
    						'format' => '%day%/%month%/%year%'
    						, 'years' => array_combine($years, $years)
    						)),
      'vanity'   => new sfWidgetFormInput(array()),
      'imagen'   => new sfWidgetFormInputFileEditable(array(
			   'label'     => sfContext::getInstance()->getI18N()->__('Imagen Principal', array(), 'notices'),
   			 'file_src'  => $this->getObject()->getProfile()->getImagen()?'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.$this->getObject()->getProfile()->getImagen():'',
			   'is_image'  => false,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '<div>' . ($this->getObject()->getProfile()->getImagen()?'<p><img src="%file%" alt="'.$this->getObject()->getProfile()->getNombre().' '.$this->getObject()->getProfile()->getApellidos().'" /> %delete% <label for="profile_imagen_delete">'. sfContext::getInstance()->getI18N()->__('Eliminar imagen actual', array(), 'notices') .'</label></p>':'') . '%input% <span class="hints">' . sfContext::getInstance()->getI18N()->__('(opcional)') . '</span></div>'
				)),
      'username'   => new sfWidgetFormInput(array()),
				
      'mails_comentarios' => new sfWidgetVoFormInputCheckbox(array('value_attribute_value'=>'1')),
      'mails_noticias' => new sfWidgetVoFormInputCheckbox(array('value_attribute_value'=>'1')),
      'mails_contacto' => new sfWidgetVoFormInputCheckbox(array('value_attribute_value'=>'1')),
      'mails_seguidor' => new sfWidgetVoFormInputCheckbox(array('value_attribute_value'=>'1')),
				
      'nombre'   => new sfWidgetFormInput(array()),
	  'apellidos'   => new sfWidgetFormInput(array()),
	  'apellidos'   => new sfWidgetFormInput(array()),
	  'presentacion'  => new sfWidgetFormTextarea(array()),
	  'passwordNew'  => new sfWidgetFormInput(array('type' => 'password'), array('autocomplete' => 'off')),
	  'passwordBis'  => new sfWidgetFormInput(array('type' => 'password')),
      'passwordOld' => new sfWidgetFormInput(array('type' => 'password')),
    ));
    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->setValidators(array(
      'fecha_nacimiento'   => new sfValidatorDate(array('required' => false), sfVoForm::getDateMessages()),   
      'vanity'   => new sfValidatorString(array("min_length" => SfVoUtil::VANITY_MIN_LENGTH, 'required' => true), sfVoForm::getStringMessages()), 
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/usuarios',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
	  'imagen_delete' => new sfValidatorString(array('required' => false)), 
      'username'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
				
      'mails_comentarios' => new sfValidatorBoolean(),
      'mails_noticias' => new sfValidatorBoolean(),
      'mails_contacto' => new sfValidatorBoolean(),
      'mails_seguidor' => new sfValidatorBoolean(),
	  
	  'nombre'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
      'apellidos'   => new sfValidatorString(array('required' => false)),    
      'presentacion'   => new sfValidatorStringCut(array("max_length" => 280, 'required' => false), sfVoForm::getStringMessages()),    
	  'passwordNew'    => new sfValidatorPassword(array('required' => false, ), sfVoForm::getStringMessages()),
      'passwordBis'    => new sfValidatorPassword(array('required' => false, ), sfVoForm::getStringMessages()),
      'passwordOld'    => new sfValidatorPasswordValid(array('required' => false), sfVoForm::getPasswordMessages()),
       ));
       

    $uniqValidator = new sfValidatorAnd(array(
    	new sfValidatorPropelUniqueUpdater(array('model'=>'sfGuardUser', 'column'=>array('username')), sfVoForm::getUniqueMessages()    ),
    	new sfValidatorPropelUniqueUpdater(array('model'=>'sfGuardUserProfile', 'column'=>array('vanity')), sfVoForm::getUniqueMessages()    )
    ));
       
    $postValidator = new sfValidatorAnd(array(
    	new sfValidatorAnd(array(
    		$uniqValidator,
    	 	new sfValidatorSchemaCompare('passwordNew',  sfValidatorSchemaCompare::EQUAL, 'passwordBis',  array(), sfVoForm::getCompareMessages())
    	)),
     	new sfValidatorRequiredIfField('passwordOld', 'passwordNew',  array(), sfVoForm::getRequiredMessages())
    ));
       
    $this->validatorSchema->setPostValidator($postValidator);
    

    

	if (!$this->isNew()) {
		// embed all enlace forms
		$idx = 0;
		foreach ($this->getObject()->getEnlaces() as $enlace) {
			$idx++;
	   		// create a new enlace form for the current enlace model object
			$enlaceForm = new UsuarioEnlaceForm( $enlace );
			// embed the enlace form in the main politico form
			$this->embedForm("enlace_n$idx", $enlaceForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema["enlace_n$idx"]->setLabel('Enlace '.$enlace->getId());

			// change the name widget to sfWidgetFormInputDelete
			$this->widgetSchema["enlace_n$idx"]['url'] = new sfWidgetFormInput(array(
			));
			$this->widgetSchema["enlace_n$idx"]['orden'] = new sfWidgetFormInputHidden();
		}

		// Vacíos
		while ($idx < 5){
			$idx++;
			// create a new enlace form for a new enlace model object
			$enlaceForm = new UsuarioEnlaceForm();
	
			// embed the enlace form in the main politico form
			$this->embedForm("enlace_n$idx", $enlaceForm);
			$this->widgetSchema["enlace_n$idx"]['orden'] = new sfWidgetFormInputHidden();
			
			// set a custom label for the embedded form
			$this->widgetSchema["enlace_n$idx"]->setLabel('Nuevo enlace');
		}
	}
    
	
  }
  
	public function bind(array $taintedValues = null, array $taintedFiles = null) {	
		// remove the embedded new form if the name field was not provided
		for ($idx = 1;$idx <= 5;$idx++){
			if (is_null($taintedValues["enlace_n$idx"]['url'])) {
		
				unset($this->embeddedForms["enlace_n$idx"], $taintedValues["enlace_n$idx"]);
		
				$this->validatorSchema["enlace_n$idx"]['url'] = new sfValidatorUrl(array('required' => false));
		
			} else {
				$this->validatorSchema["enlace_n$idx"]['url'] = new sfVoValidatorUrl(array('required' => false), sfVoForm::getUrlMessages());
				$this->embeddedForms["enlace_n$idx"]->getObject()->setSfGuardUser($this->getObject());
		
			}
		}
	
		// call parent bind method
		parent::bind($taintedValues, $taintedFiles);
	
	}
}
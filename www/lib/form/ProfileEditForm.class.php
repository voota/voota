<?php
class ProfileEditForm extends sfGuardUserAdminForm
{
 
  public function configure()
  {
	$years = range(1920,date('Y'));
	
    $this->setWidgets(array(
      'fecha_nacimiento'   => new sfWidgetFormJQueryDate(array(
    						'culture' => 'es'
    						, 'format' => '%day%/%month%/%year%'
    						, 'years' => array_combine($years, $years)
    						)),
      'vanity'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'imagen'   => new sfWidgetFormInputFileEditable(array(
			   'label'     => sfContext::getInstance()->getI18N()->__('Imagen Principal', array(), 'notices'),
   			   'file_src'  => 'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.$this->getObject()->getProfile()->getImagen(),
			   'is_image'  => true,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '<div>%file%  <label></label>%input%<br /><label></label><h6>%delete% '. sfContext::getInstance()->getI18N()->__('Eliminar imagen actual', array(), 'notices') .'</h6></div>',
				)),
      'username'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'nombre'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'apellidos'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'passwordNew'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
	  'passwordBis'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
      'passwordOld' => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('profile[%s]');
	$this->widgetSchema->setLabels(array(
	  'fecha_nacimiento'    => sfContext::getInstance()->getI18N()->__('Fecha de nacimiento', array(), 'notices'),
	  'vanity'    => 'Url: http://voota.es/',
  	  'username'    => 'Email',
	  'nombre'    => sfContext::getInstance()->getI18N()->__('Nombre', array(), 'notices'),
	  'apellidos'    => sfContext::getInstance()->getI18N()->__('Apellidos', array(), 'notices'),
	  'passwordNew'    => sfContext::getInstance()->getI18N()->__('Password', array(), 'notices'),
	  'passwordBis'    => sfContext::getInstance()->getI18N()->__('Password (otra vez)', array(), 'notices'),
	  'passwordOld'    => sfContext::getInstance()->getI18N()->__('Password actual', array(), 'notices'),
	)); 
    $this->setValidators(array(
      'fecha_nacimiento'   => new sfValidatorDate(array('required' => false), sfVoForm::getDateMessages()),   
      'vanity'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()), 
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/usuarios',
				   'validated_file_class' => 'sfResizedFile',
	  )),
	  'imagen_delete' => new sfValidatorString(array('required' => false)), 
      'username'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
      'nombre'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
      'apellidos'   => new sfValidatorString(array('required' => false)),    
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
    

    


	
  }
}
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
			   'label'     => 'Imagen Principal',
			   'file_src'  => '/images/usuarios/cc_s_'.$this->getObject()->getProfile()->getImagen(),
			   'is_image'  => true,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '<div>%file%  <label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
				)),
      'username'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'nombre'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'apellidos'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'passwordNew'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
	  'passwordBis'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
      'password_old' => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('profile[%s]');
	$this->widgetSchema->setLabels(array(
	  'fecha_nacimiento'    => 'Fecha de nacimiento',
	  'vanity'    => 'Url: http://voota.es/',
  	  'username'    => 'Email',
	  'apellidos'    => 'Apellidos',
	  'passwordNew'    => 'Password',
	  'passwordBis'    => 'Password (otra vez)',
	  'password_old'    => 'Password actual',
	)); 
    $this->setValidators(array(
      'fecha_nacimiento'   => new sfValidatorDate(array('required' => false), sfVoForm::$messagesDate),   
      'vanity'   => new sfValidatorString(array('required' => true)), 
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/usuarios',
				   'validated_file_class' => 'sfResizedFile',
	  )),
	  'imagen_delete' => new sfValidatorString(array('required' => false)), 
      'username'   => new sfValidatorAnd(array(
    	new sfValidatorString(array('required' => true)),  
        new sfValidatorEmail(array(), sfVoForm::$messagesEmail),  
        //new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => 'username'), array('invalid' => 'name in use')),
       )),
      'nombre'   => new sfValidatorString(array('required' => true), sfVoForm::$messagesString),      
      'apellidos'   => new sfValidatorString(array('required' => false)),    
      'passwordNew'    => new sfValidatorPassword(array('required' => false, ), sfVoForm::$messagesString),
      'passwordBis'    => new sfValidatorPassword(array('required' => false, ), sfVoForm::$messagesString),
      'password_old'    => new sfValidatorString(array('required' => false)),
       ));
       

    $uniqValidator = new sfValidatorAnd(array(
    	new sfValidatorPropelUniqueUpdater(array('model'=>'sfGuardUser', 'column'=>array('username')), sfVoForm::$messagesUnique    ),
    	new sfValidatorPropelUniqueUpdater(array('model'=>'sfGuardUserProfile', 'column'=>array('vanity')), sfVoForm::$messagesUnique    )
    ));
       
    $postValidator = new sfValidatorAnd(array(
    	$uniqValidator,
    	 new sfValidatorSchemaCompare('passwordNew',  sfValidatorSchemaCompare::EQUAL, 'passwordBis',  array(), sfVoForm::$messagesCompare)
    ));
       
    $this->validatorSchema->setPostValidator($postValidator);
    

    


	
  }
}
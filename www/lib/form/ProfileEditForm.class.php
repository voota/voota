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
	  'password'  => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'password_again'  => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'password_old' => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('profile[%s]');
 
    $this->setValidators(array(
      'fecha_nacimiento'   => new sfValidatorDate(array('required' => false)),   
      'vanity'   => new sfValidatorString(array('required' => true)), 
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/usuarios',
				   'validated_file_class' => 'sfResizedFile',
	  )),
      'username'   => new sfValidatorAnd(array(
    	new sfValidatorString(array('required' => true)),  
        new sfValidatorEmail(),  
        //new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => 'username'), array('invalid' => 'name in use')),
       )),
      'nombre'   => new sfValidatorString(array('required' => true)),      
      'apellidos'   => new sfValidatorString(array('required' => false)),    
      'password'    => new sfValidatorString(array('required' => false)),
      'password_again'    => new sfValidatorString(array('required' => false)),
      'password_old'    => new sfValidatorString(array('required' => false)),
       ));
       
	
	
  }
}
<?php
class NuevaPropuestaForm extends PropuestaForm
{
 
  public function configure()
  {
    $this->setWidgets(array(
      'op' => new sfWidgetFormInputHidden(),
      'titulo'   => new sfWidgetFormInputText(array()),
      'descripcion'   => new sfWidgetFormInputText(array()),
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
      'titulo'   => new sfValidatorEmail(array('required' => true), sfVoForm::getStringMessages()),  
      'descripcion'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/propuestas',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
      'doc'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/propuestas',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
    ));
    
  }
}
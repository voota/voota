<?php
class NuevoDocPropuestaForm extends BasePropuestaForm
{
  public function configure()
  {
  	unset(
  		$this['id']
  		, $this['vanity']
  		, $this['titulo']
  		, $this['descripcion']
  		, $this['imagen']
  	);
  	
    $this->setWidgets(array(
      'doc'   => new sfWidgetFormInputFileEditable(array(
			   'label'     => sfContext::getInstance()->getI18N()->__('Imagen', array(), 'notices'),
   			   'file_src'  => $this->getObject()?''.S3Voota::getImagesUrl().'/usuarios/cc_s_'.$this->getObject()->getDoc():'',
			   'is_image'  => false,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '%input%'
				)),
    ));
    $this->widgetSchema->setNameFormat('propuesta[%s]');
	$this->setValidators(array(
      'doc'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'path' => sfConfig::get('sf_upload_dir').'/docs',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
    ));
  }
}
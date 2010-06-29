<?php

/**
 * Propuesta form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 */
class PropuestaForm extends BasePropuestaForm
{
  public function configure()
  {
  	unset(
  		$this['sumu']
  		, $this['sumd']
  		, $this['created_at']
  		, $this['modified_at']
  		, $this['doc']
  		, $this['doc_size']
  	);
    $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea(array(), array('style' => "width: 500px; height:200px"));
    $this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
	   'label'     => 'Imagen Principal',
	   'file_src'  => S3Voota::getImagesUrl().'/propuestas/cc_'.$this->getObject()->getImagen(),
	   'is_image'  => true,
	   'edit_mode' => !$this->isNew(),
	   'template'  => '<div>%file% <br /> %input%<br />%delete% Eliminar imagen actual</div>',
	));
	
	$this->widgetSchema['doc'] = new sfWidgetFormInputFileEditable(array(
	   'label'     => sfContext::getInstance()->getI18N()->__('Doc', array(), 'notices'),
   	   'file_src'  => $this->getObject()?''.S3Voota::getImagesUrl().'/docs/'.$this->getObject()->getDoc():'',
	   'is_image'  => false,
	   'edit_mode' => !$this->isNew(),
	   'template'  => '<div>%file% <br /> %input% <span class="hints">' . sfContext::getInstance()->getI18N()->__('(opcional)'). '<br />'.($this->getObject()->getDoc()?'%delete% Eliminar documento actual':'') . '</div>'
	));
	
    $this->validatorSchema['imagen'] = new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/propuestas',
				   'validated_file_class' => 'sfResizedFile',
	), sfVoForm::getImageMessages("500K"));
	  
    $this->validatorSchema['doc'] = new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '2048000',
				   'path' => sfConfig::get('sf_upload_dir').'/docs',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages("2M"));
	  
	$this->validatorSchema['imagen_delete'] = new sfValidatorBoolean();
	$this->validatorSchema['doc_delete'] = new sfValidatorBoolean();
	
  }
  
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		$vanity = isset($taintedValues['vanity'])?$taintedValues['vanity']:false;
		$titulo = isset($taintedValues['titulo'])?$taintedValues['titulo']:false;
		$descripcion = isset($taintedValues['descripcion'])?$taintedValues['descripcion']:false;
		$id = isset($taintedValues['id'])?$taintedValues['id']:false;
		
		if ($titulo){
			$taintedValues['titulo'] = SfVoUtil::cutToLength($taintedValues['titulo'], 80);
		}		
		if ($descripcion){
			$taintedValues['descripcion'] = SfVoUtil::cutToLength($taintedValues['descripcion'], 600);
		}		
		
		if ($vanity){
			$taintedValues['vanity'] = SfVoUtil::fixVanityChars( $vanity ); 	
		}
		else {
			if (!$id){
				$taintedValues['vanity'] = SfVoUtil::fixVanityChars( $taintedValues['titulo'] );
			}
		}

		if (!$this->isNew()) {
			if (isset($taintedValues['enlace'])){
				if (is_null($taintedValues['enlace']['url']) || strlen($taintedValues['enlace']['url']) === 0 ) {
					unset($this->embeddedForms['enlace'], $taintedValues['enlace']);
			
					$this->validatorSchema['enlace'] = new sfValidatorPass();
			
				} else {
					$this->embeddedForms['enlace']->getObject()->
			                setPropuesta($this->getObject());
				}
			}
			
			if (isset($taintedValues['institucion'])){
				if (is_null($taintedValues['institucion']['institucion_id']) || strlen($taintedValues['institucion']['institucion_id']) === 0 ) {
					unset($this->embeddedForms['institucion'], $taintedValues['institucion']);
			
					$this->validatorSchema['institucion'] = new sfValidatorPass();
			
				} else {
					$this->embeddedForms['institucion']->getObject()->
			                setPropuesta($this->getObject());
				}
			}
		}	
		
		parent::bind($taintedValues, $taintedFiles);
	}
}

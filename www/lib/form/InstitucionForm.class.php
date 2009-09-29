<?php

/**
 * Institucion form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class InstitucionForm extends BaseInstitucionForm
{
  protected static $estados = array('N' => 'No', 'S' => 'Sí');
  
  public function configure()
  {
    $this->widgetSchema['disabled'] = new sfWidgetFormSelect(array('choices' => self::$estados));

  
  
	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
   'label'     => 'Imagen Principal',
   'file_src'  => '/images/instituciones/'.$this->getObject()->getImagen(),
   'is_image'  => true,
   'edit_mode' => !$this->isNew(),
   'template'  => '<div>%file% <label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
	));
	
	$this->validatorSchema['imagen'] = new sfValidatorFile(array(
   'required'   => false,
   'mime_types' => 'web_images',
   'path' => sfConfig::get('sf_upload_dir').'/instituciones',
   'validated_file_class' => 'sfResizedFile',
	));
    
  
  
  
  
  }
}

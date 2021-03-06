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

  protected function processUploadedFile($field, $filename = null, $values = null)
  {
  	  $column = call_user_func(array(constant(get_class($this->getObject()).'::PEER'), 'translateFieldName'), $field, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
      $getter = 'get'.$column;

      return $this->getObject()->$getter();
  }
  
  public function configure()
  {  	
  	unset($this['politico_institucion_list'], $this['eleccion_institucion_list'], $this['created_at']);
  	
    $this->embedI18n(array('es', 'ca'));
    
    $this->widgetSchema['disabled'] = new sfWidgetFormSelect(array('choices' => self::$estados));

  
  
	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
   'label'     => 'Imagen Principal',
   'file_src'  => S3Voota::getImagesUrl().'/instituciones/cc_s_'.$this->getObject()->getImagen(),
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
	
	$this->validatorSchema['imagen_delete'] = new sfValidatorBoolean();
  }
  
  protected function setValue($key, $value) {
  	$this->values[$key] = $value;
  }
  protected function doSave($con = null)
  {
  	$institucion = $this->getObject();
    if ($this->getValue('vanity') == ''){
    	$vanityUrl = SfVoUtil::encodeVanity( $this->getValue('nombre_corto') );
    	
	    $c2 = new Criteria();
	    $c2->add(InstitucionI18nPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
	    $c2->add(InstitucionPeer::ID, $institucion->getId(), Criteria::NOT_EQUAL);
	    $usuariosLikeMe = InstitucionPeer::doSelect( $c2 );
	    $counter = 0;
	    foreach ($usuariosLikeMe as $usuarioLikeMe){
	    	$counter++;
	    }
	    $this->setValue( 'vanity', "$vanityUrl". ($counter==0?'':"-$counter") );
    }
    
  	parent::doSave($con);
  }
}

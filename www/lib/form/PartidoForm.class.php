<?php

/**
 * Partido form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PartidoForm extends BasePartidoForm
{
  public function configure()
  {
	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
   'label'     => 'Imagen Principal',
   'file_src'  => 'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/cc_'.$this->getObject()->getImagen(),
   'is_image'  => true,
   'edit_mode' => !$this->isNew(),
   'template'  => '<div>%file%  <img src="https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/bw_'.$this->getObject()->getImagen().'"><br /><label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
	));
	
	$this->validatorSchema['imagen'] = new sfValidatorFile(array(
   'required'   => false,
   'mime_types' => 'web_images',
	'path' => sfConfig::get('sf_upload_dir').'/partidos',
   'validated_file_class' => 'sfResizedFile',
	));
  }
}

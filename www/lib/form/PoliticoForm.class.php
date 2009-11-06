<?php

/**
 * Politico form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PoliticoForm extends BasePoliticoForm
{
  protected static $generos = array('N' => '?', 'H' => 'Hombre', 'M' => 'Mujer');
  protected static $relaciones = array(
  									'N' => '?',
  									'SO' => 'Soltero/a',
								    'RE' => 'En una relación',
								    'CO' => 'Comprometido/a',
								    'CA' => 'Casado/a',
								    'ES' => 'Es complicado',
								    'RA' => 'En una relación abierta',
								    'VI' => 'Viudo(a)',
								 );

  
  

  public function configure()
  {

    $this->widgetSchema['sexo'] = new sfWidgetFormSelect(array('choices' => self::$generos));
    $this->widgetSchema['relacion'] = new sfWidgetFormSelect(array('choices' => self::$relaciones));
    
    $years = range(1920,date('Y'));
    $this->widgetSchema['fecha_nacimiento'] = new sfWidgetFormJQueryDate(array(
    						'culture' => 'es'
    						, 'format' => '%day%/%month%/%year%'
    						, 'years' => array_combine($years, $years)
    						));

	$this->widgetSchema['imagen'] = new sfWidgetFormInputFileEditable(array(
   'label'     => 'Imagen Principal',
   'file_src'  => 'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_'.$this->getObject()->getImagen(),
   'is_image'  => true,
   'edit_mode' => !$this->isNew(),
   'template'  => '<div>%file%  <img src="https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/bw_'.$this->getObject()->getImagen().'"><br /><label></label>%input%<br /><label></label>%delete% Eliminar imagen actual</div>',
	));
	
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));  
	$this->validatorSchema['imagen'] = new sfValidatorFile(array(
   'required'   => false,
   'mime_types' => 'web_images',
	'path' => sfConfig::get('sf_upload_dir').'/politicos',
   'validated_file_class' => 'sfResizedFile',
	));
	
 }
}

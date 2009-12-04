<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class ProfileEditForm extends sfGuardUserAdminForm
{
 
  public function configure()
  {
	$years = range(1920,date('Y'));
	
    $this->setWidgets(array(
      'fecha_nacimiento'   => new sfWidgetFormDate(array(
    						'format' => '%day%/%month%/%year%'
    						, 'years' => array_combine($years, $years)
    						)),
      'vanity'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'imagen'   => new sfWidgetFormInputFileEditable(array(
			   'label'     => sfContext::getInstance()->getI18N()->__('Imagen Principal', array(), 'notices'),
   			   'file_src'  => $this->getObject()->getProfile()->getImagen()?'https://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.$this->getObject()->getProfile()->getImagen():'',
			   'is_image'  => true,
			   'edit_mode' => !$this->isNew(),
			   'template'  => '<div>%file%  <label></label>%input%<br /><label></label><h6>%delete% '. sfContext::getInstance()->getI18N()->__('Eliminar imagen actual', array(), 'notices') .'</h6></div>',
				)),
      'username'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
      'nombre'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'apellidos'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'apellidos'   => new sfWidgetFormInput(array(), array('class' => 'inputSign')),
	  'presentacion'  => new sfWidgetFormTextarea(array(), array('class' => 'inputSign')),
	  'passwordNew'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign', 'autocomplete' => 'off')),
	  'passwordBis'  => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
      'passwordOld' => new sfWidgetFormInput(array('type' => 'password'), array('class' => 'inputSign')),
    ));
    $this->widgetSchema->setNameFormat('profile[%s]');

    $this->setValidators(array(
      'fecha_nacimiento'   => new sfValidatorDate(array('required' => false), sfVoForm::getDateMessages()),   
      'vanity'   => new sfValidatorString(array("min_length" => SfVoUtil::VANITY_MIN_LENGTH, 'required' => true), sfVoForm::getStringMessages()), 
      'imagen'   => new sfValidatorFile(array(
				   'required'   => false,
    			   'max_size' => '512000',
				   'mime_types' => 'web_images',
				   'path' => sfConfig::get('sf_upload_dir').'/usuarios',
				   'validated_file_class' => 'sfResizedFile',
	  ), sfVoForm::getImageMessages()),
	  'imagen_delete' => new sfValidatorString(array('required' => false)), 
      'username'   => new sfValidatorEmail(array('required' => true), sfVoForm::getEmailMessages()),  
      'nombre'   => new sfValidatorString(array('required' => true), sfVoForm::getStringMessages()),      
      'apellidos'   => new sfValidatorString(array('required' => false)),    
      'presentacion'   => new sfValidatorString(array("max_length" => 280, 'required' => false), sfVoForm::getStringMessages()),    
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
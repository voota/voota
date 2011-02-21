<?php

/**
 * EleccionInstitucion form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EleccionInstitucionForm extends BaseEleccionInstitucionForm
{
  public function configure()
  {   	
	unset(
		$this['created_at']
	);
  	
	$this->widgetSchema['eleccion_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['institucion_id'] = new sfWidgetFormChoiceDelete(array(
      'model_id' => $this->getObject()->getInstitucionId(),
      'parent_id' => $this->getObject()->getEleccionId(),
      'name' => $this->getObject()->getInstitucion()?$this->getObject()->getInstitucion()->getNombre('es'):'',
      'choices'          => array(),
      'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
      'renderer_options' => array(
	      'model' => 'Institucion',
	      'url'   => $this->getOption('url')
      ),
	  'module' => 'eleccion'
  	));  	
  }
}

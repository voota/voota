<?php

/**
 * PoliticoInstitucion form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PoliticoInstitucionForm extends BasePoliticoInstitucionForm
{
	
  protected static $cargos = array(
  									'' => '?',
  									'CJ' => 'Concejal',
								    'AL' => 'Alcalde'
								 );
								 
  public function configure()
  {   	
  	unset(
  		$this['fecha_inicio']
  		, $this['fecha_fin']
  		, $this['cargo']
  		//, $this['sf_guard_user_profile_id']
  	);
  	
    //$this->widgetSchema['politico_id'] = new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true));
      $this->widgetSchema['politico_id'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['institucion_id'] = new sfWidgetFormChoiceDelete(array(
      'model_id' => $this->getObject()->getInstitucionId(),
      'parent_id' => $this->getObject()->getPoliticoId(),
      'name' => $this->getObject()->getInstitucion()?$this->getObject()->getInstitucion()->getNombre('es'):'',
      'choices'          => array(),
    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
    'renderer_options' => array(
      'model' => 'Institucion',
      'url'   => $this->getOption('url')
    )
  ));
	//$this->widgetSchema['cargo'] = new sfWidgetFormSelect(array('choices' => self::$cargos));
  	
  }
}

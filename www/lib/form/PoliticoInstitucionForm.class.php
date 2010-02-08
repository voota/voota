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
  public function configure()
  { 
    //$this->widgetSchema['politico_id'] = new sfWidgetFormPropelChoice(array('model' => 'Politico', 'add_empty' => true));
    $this->widgetSchema['institucion_id'] = new sfWidgetFormPropelChoice(array('model' => 'Institucion', 'add_empty' => true));
  	
  }
}

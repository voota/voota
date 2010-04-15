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
  	);
    $this->widgetSchema['descripcion'] = new sfWidgetFormTextarea(array(), array('style' => "width: 500px; height:200px"));
  }
  
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		$vanity = $taintedValues['vanity'];
		if ($vanity){
			$taintedValues['vanity'] = SfVoUtil::fixVanityChars( $vanity ); 	
		}
		else {
			if (!$taintedValues['id']){
				$taintedValues['vanity'] = SfVoUtil::fixVanityChars( $taintedValues['titulo'] );
			}
		}
		
		parent::bind($taintedValues, $taintedFiles);
	}
}

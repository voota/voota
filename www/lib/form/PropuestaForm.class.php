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
		$vanity = isset($taintedValues['vanity'])?$taintedValues['vanity']:false;
		$id = isset($taintedValues['id'])?$taintedValues['id']:false;
		
		if ($vanity){
			$taintedValues['vanity'] = SfVoUtil::fixVanityChars( $vanity ); 	
		}
		else {
			if (!$id){
				$taintedValues['vanity'] = SfVoUtil::fixVanityChars( $taintedValues['titulo'] );
			}
		}

		if (!$this->isNew()) {
			if (is_null($taintedValues['enlace']['url']) || strlen($taintedValues['enlace']['url']) === 0 ) {
				unset($this->embeddedForms['enlace'], $taintedValues['enlace']);
		
				$this->validatorSchema['enlace'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['enlace']->getObject()->
		                setPropuesta($this->getObject());
			}
			
		
			if (is_null($taintedValues['institucion']['institucion_id']) || strlen($taintedValues['institucion']['institucion_id']) === 0 ) {
				unset($this->embeddedForms['institucion'], $taintedValues['institucion']);
		
				$this->validatorSchema['institucion'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['institucion']->getObject()->
		                setPropuesta($this->getObject());
			}
		}	
		
		parent::bind($taintedValues, $taintedFiles);
	}
}

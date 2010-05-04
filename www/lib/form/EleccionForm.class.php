<?php

/**
 * Eleccion form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class EleccionForm extends BaseEleccionForm
{
  public function configure()
  {
  	unset(
  		$this['eleccion_institucion_list']
  	);
  	
  	
	$this->widgetSchema['sf_eleccion_id'] = new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Institucion',
	      'url'   => $this->getOption('url')
	    )
	));
	
  	if (!$this->isNew()) {
		// embed all institucion forms
		foreach ($this->getObject()->getEleccionInstitucions() as $institucion) {
	   		// create a new insti form for the current insti model object
			$institucionForm = new EleccionInstitucionForm( $institucion );
			$institucionForm->setOption('url', $this->getOption('url'));
			$institucionForm->configure();
			
			// embed the institucion form in the main eleccion form
			$this->embedForm('institucion'.$institucion->getInstitucion()->getId(), $institucionForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema['institucion'.$institucion->getInstitucion()->getId()]->setLabel('Institucion '.$institucion->getInstitucion()->getId());

			// change the name widget to sfWidgetFormInputDelete
			/*
			$this->widgetSchema['institucion'.$institucion->getInstitucion()->getId()]['url'] = new sfWidgetFormInputDelete(array(
				'url' => 'eleccion/deleteInstitucion',      // required
				'model_id' => $institucion->getInstitucion()->getId(),        // required
				'confirm' => 'Sure???',                     // optional
			));
			*/
		}

		// create a new institucion form for a new institucion model object
		$eleccionInstitucion = new EleccionInstitucion();
		$eleccionInstitucion->setEleccionId( $this->getObject()->getId() );
		$institucionForm = new EleccionInstitucionForm( $eleccionInstitucion );
		$institucionForm->setOption('url', $this->getOption('url'));
		$institucionForm->configure();

		// embed the institucion form in the main eleccion form
		$this->embedForm('institucion', $institucionForm);

		// set a custom label for the embedded form
		$this->widgetSchema['institucion']->setLabel('Nueva institución');
	}
  }
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		if (!$this->isNew()) {
			/*
			if (is_null($taintedValues['enlace']['url']) || strlen($taintedValues['enlace']['url']) === 0 ) {
				unset($this->embeddedForms['enlace'], $taintedValues['enlace']);
		
				$this->validatorSchema['enlace'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['enlace']->getObject()->
		                setEleccion($this->getObject());
			}
			*/
		
			if (is_null($taintedValues['institucion']['institucion_id']) || strlen($taintedValues['institucion']['institucion_id']) === 0 ) {
				unset($this->embeddedForms['institucion'], $taintedValues['institucion']);
		
				$this->validatorSchema['institucion'] = new sfValidatorPass();
		
			} else {
				$this->embeddedForms['institucion']->getObject()->
		                setEleccion($this->getObject());
			}
		}	
		parent::bind($taintedValues, $taintedFiles);
	}
}

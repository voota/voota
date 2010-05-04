<?php

/**
 * Lista form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class ListaForm extends BaseListaForm
{
  public function configure()
  {
  	unset(
  		$this['politico_lista_list'],
  		$this['partido_lista_list']
  	);
  	
  	
	$this->widgetSchema['sf_lista_id'] = new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Politico',
	      'url'   => $this->getOption('url')
	    )
	));
	
  	if (!$this->isNew()) {
		// embed all forms
		foreach ($this->getObject()->getPoliticoListas() as $politico) {
			$politicoForm = new PoliticoListaForm( $politico );
			$politicoForm->setOption('url', $this->getOption('url'));
			$politicoForm->configure();
			
			$this->embedForm('politico'.$politico->getPolitico()->getId(), $politicoForm);
			
			// set a custom label for the embedded form
			$this->widgetSchema['politico'.$politico->getPolitico()->getId()]->setLabel('Político '.$politico->getPolitico()->getId());
		}

		$listaPolitico = new PoliticoLista();
		$listaPolitico->setListaId( $this->getObject()->getId() );
		$politicoForm = new PoliticoListaForm( $listaPolitico );
		$politicoForm->setOption('url', $this->getOption('url'));
		$politicoForm->configure();

		$this->embedForm('politico', $politicoForm);

		// set a custom label for the embedded form
		$this->widgetSchema['politico']->setLabel('Nuevo político');
	}
  }
	public function bind(array $taintedValues = null, array $taintedFiles = null) {
		if (!$this->isNew()) {
			if (is_null($taintedValues['politico']['politico_id']) || strlen($taintedValues['politico']['politico_id']) === 0 ) {
				unset($this->embeddedForms['politico'], $taintedValues['politico']);
		
				$this->validatorSchema['politico'] = new sfValidatorPass();
			} 
			else {
				$this->embeddedForms['politico']->getObject()->setLista($this->getObject());
			}
		}	
		parent::bind($taintedValues, $taintedFiles);
	}
}

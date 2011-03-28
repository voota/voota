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
  public function setup()
  {
    parent::setup();
    
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'partido_id'          => new sfWidgetFormPropelChoice(array('model' => 'Partido', 'add_empty' => false)),
      'convocatoria_id'     => new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Convocatoria',
	      'url'   => $this->getOption('url_co')
	    )
	  )),
      'circunscripcion_id'  => new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Circunscripcion',
	      'url'   => $this->getOption('url_ci')
	    )
	  )),
      'created_at'          => new sfWidgetFormDateTime(),
      'politico_lista_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Politico')),
      'partido_lista_list'  => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Partido')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Lista', 'column' => 'id', 'required' => false)),
      'partido_id'          => new sfValidatorPropelChoice(array('model' => 'Partido', 'column' => 'id')),
      'convocatoria_id'     => new sfValidatorPropelChoice(array('model' => 'Convocatoria', 'column' => 'id')),
      'circunscripcion_id'  => new sfValidatorPropelChoice(array('model' => 'Circunscripcion', 'column' => 'id', 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'politico_lista_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Politico', 'required' => false)),
      'partido_lista_list'  => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Partido', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Lista', 'column' => array('partido_id', 'convocatoria_id', 'circunscripcion_id')))
    );

    $this->widgetSchema->setNameFormat('lista[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }
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
  	  
	$this->widgetSchema['convocatoria_id'] = new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Convocatoria',
	      'url'   => $this->getOption('url_co')
	    )
	));
  	  	
	$this->widgetSchema['circunscripcion_id'] = new sfWidgetFormChoice(array(
	    'choices'          => array(),
	    'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
	    'renderer_options' => array(
	      'model' => 'Circunscripcion',
	      'url'   => $this->getOption('url_ci')
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
		
		$c = new Criteria();
	  	$c->add(PoliticoListaPeer::LISTA_ID, $this->getObject()->getId());
	  	$c->addAscendingOrderByColumn(PoliticoListaPeer::ORDEN);
	  	$this->listaPoliticos = PoliticoListaPeer::doSelect( $c );
		
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

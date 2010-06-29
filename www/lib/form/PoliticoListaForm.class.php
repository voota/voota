<?php

/**
 * PoliticoLista form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PoliticoListaForm extends BasePoliticoListaForm
{
  public function configure()
  {   	
	unset(
		$this['created_at']
	);
  	
	$this->widgetSchema['lista_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['politico_id'] = new sfWidgetFormChoiceDelete(array(
      'model_id' => $this->getObject()->getPoliticoId(),
      'parent_id' => $this->getObject()->getListaId(),
      'name' => $this->getObject()->getPolitico()?$this->getObject()->getPolitico():'',
      'choices'          => array(),
      'renderer_class'   => 'sfWidgetFormPropelJQueryAutocompleter',
      'renderer_options' => array(
	      'model' => 'Politico',
	      'url'   => $this->getOption('url')
      ),
	  'module' => 'lista'
  	));  	
  }
}

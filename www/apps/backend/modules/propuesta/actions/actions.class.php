<?php

require_once dirname(__FILE__).'/../lib/propuestaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/propuestaGeneratorHelper.class.php';

/**
 * propuesta actions.
 *
 * @package    sf_sandbox
 * @subpackage propuesta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class propuestaActions extends autoPropuestaActions
{
	
	
	public function executeUpdate(sfWebRequest $request)
  	{
  		parent::executeUpdate( $request );
  		if($this->form->getValue('imagen_delete') == "on"){
			$this->form->getObject()->setImagen( null );
		}
  		if($this->form->getValue('doc_delete') == "on"){
			$this->form->getObject()->setDoc( null );
		}
		$this->form->getObject()->save();
  	}
		  	
	
}

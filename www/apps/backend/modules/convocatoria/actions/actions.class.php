<?php

require_once dirname(__FILE__).'/../lib/convocatoriaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/convocatoriaGeneratorHelper.class.php';

/**
 * convocatoria actions.
 *
 * @package    sf_sandbox
 * @subpackage convocatoria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class convocatoriaActions extends autoConvocatoriaActions
{
	public function executeUpdate(sfWebRequest $request)
  	{
	    $this->Convocatoria = $this->getRoute()->getObject();
	    $this->form = $this->configuration->getForm($this->Convocatoria);
	
	    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
  	
    	if(! $this->Convocatoria->getClosedAt() && $this->form->getValue('closed_at')){
  			$this->Convocatoria->close();
    	}
    	if($this->Convocatoria->getClosedAt() && !$this->form->getValue('closed_at')){
  			$this->Convocatoria->reopen();
    	}
	    $this->processForm($request, $this->form);
	    
  		if($this->form->getValue('imagen_delete') == "on"){
			$this->form->getObject()->setImagen( null );
		}
		$this->form->getObject()->save();
  	}
	
	public function executeEdit(sfWebRequest $request) {
		$this->configuration->setEnlaces($this->getRoute()->getObject()->getEnlaces());			
		
		parent::executeEdit( $request );
		$this->form->configure();
	}
	
	public function executeDeleteEnlace(sfWebRequest $request) {
	  $enlace = EnlacePeer::retrieveByPk($request->getParameter('id'));
	  $enlace->delete();
	  $this->redirect('@convocatoria_edit?id='.$enlace->getConvocatoria()->getId());
	}
}

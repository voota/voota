<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__).'/../lib/partidoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/partidoGeneratorHelper.class.php';

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class partidoActions extends autoPartidoActions
{
  public function executeUpdate(sfWebRequest $request)
  {
  	$this->configuration->setEnlaces($this->getRoute()->getObject()->getEnlaces());
  		
  	$this->partido = $this->getRoute()->getObject();
  	$this->form = $this->configuration->getForm($this->partido);
  	
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
  	if ($this->form->isValid()) {
	  		if($this->form->getValue('imagen_delete') == "on"){
				    $this->form->getObject()->setImagen( null );
	  		}
	  	$imagen = $this->form->getValue('imagen');
	    if ($imagen && $imagen->getOriginalName()){
			$arr = array_reverse( split("\.", $imagen->getOriginalName()) );
			$ext = strtolower($arr[0]);
			if (!$ext || $ext == ""){
			  	$ext = "png";
			}     
		    $imageName = $this->form->getValue('vanity');
		      
		    $imageName .= ".$ext";
		    $imagen->save(sfConfig::get('sf_upload_dir').'/partidos/'.$imagen->getOriginalName());
		    $this->form->getObject()->setImagen( $imagen->getOriginalName() );
	    }
    }
    $this->processForm($request, $this->form);
    
    $this->setTemplate('edit');
  }
  
	public function executeEdit(sfWebRequest $request) {
		$this->configuration->setEnlaces($this->getRoute()->getObject()->getEnlaces());		
		parent::executeEdit( $request );
	}	
	
	public function executeDelete(sfWebRequest $request) {
		$id = $request->getParameter('id');
		SfReviewManager::deleteReview(1, $id);
		
	    $criteria = new Criteria();
	  	$criteria->add(PartidoInstitucionPeer::PARTIDO_ID, $id);
	  	PartidoInstitucionPeer::doDelete( $criteria );
		
	    $criteria = new Criteria();
	  	$criteria->add(EnlacePeer::PARTIDO_ID, $id);
	  	EnlacePeer::doDelete( $criteria );
	  	
		parent::executeDelete($request);
	}
	
	public function executeDeleteEnlace(sfWebRequest $request) {
	  $enlace = EnlacePeer::retrieveByPk($request->getParameter('id'));
	  $enlace->delete();
	  $this->redirect('@partido_edit?id='.$enlace->getPartido()->getId());
	}
	
}

<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__).'/../lib/politicoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/politicoGeneratorHelper.class.php';

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class politicoActions extends autoPoliticoActions
{
	public function executeUpdate(sfWebRequest $request)
  	{
	  	$cacheManager = $this->getContext()->getViewCacheManager();
	  	if ($cacheManager != null) {
	  		$politico = $this->getRoute()->getObject();
	    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."&sf_culture=es");
	    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."&sf_culture=ca");
	  	}
  		$this->configuration->setEnlaces($this->getRoute()->getObject()->getEnlaces());	

  		
	    $this->politico = $this->getRoute()->getObject();
	  	$this->form = $this->configuration->getForm($this->politico);
	  	
	    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
	  	if ($this->form->isValid()) {
		  	$imagen = $this->form->getValue('imagen');
		    if ($imagen && $imagen->getOriginalName()){
				$arr = array_reverse( split("\.", $imagen->getOriginalName()) );
				$ext = strtolower($arr[0]);
				if (!$ext || $ext == ""){
				  	$ext = "png";
				}     
			    $imageName = $this->form->getValue('vanity');
			      
			    $imageName .= ".$ext";
			    $imagen->save(sfConfig::get('sf_upload_dir').'/politicos/'.$imagen->getOriginalName());
			    $this->form->getObject()->setImagen( $imagen->getOriginalName() );
		    }
	    }
	    $this->processForm($request, $this->form);
	
	    $this->setTemplate('edit');
   	}
	
	public function executeEdit(sfWebRequest $request) {
/*	
		if ($this->getRoute()->getObject()->getImagen()) {
			$imageFileName = sfConfig::get('sf_upload_dir').'/politicos/'.$this->getRoute()->getObject()->getImagen();
			if (file_exists($imageFileName)){
				$img = new sfImage( $imageFileName );
				$img->politico( $imageFileName );
			}
		}
*/
		$this->configuration->setEnlaces($this->getRoute()->getObject()->getEnlaces());		
		parent::executeEdit( $request );
	}
	public function executeDelete(sfWebRequest $request) {
		$id = $request->getParameter('id');
		SfReviewManager::deleteReview(1, $id);
		
	    $criteria = new Criteria();
	  	$criteria->add(PoliticoInstitucionPeer::POLITICO_ID, $id);
	  	PoliticoInstitucionPeer::doDelete( $criteria );
		
	    $criteria = new Criteria();
	  	$criteria->add(EnlacePeer::POLITICO_ID, $id);
	  	EnlacePeer::doDelete( $criteria );
	  	
		parent::executeDelete($request);
	}
	
	public function executeDeleteEnlace(sfWebRequest $request) {
	  $enlace = EnlacePeer::retrieveByPk($request->getParameter('id'));
	  $enlace->delete();
	  $this->redirect('@politico_edit?id='.$enlace->getPolitico()->getId());
	}
	
}

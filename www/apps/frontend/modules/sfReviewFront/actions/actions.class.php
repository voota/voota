<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage review
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

require_once(sfConfig::get('sf_plugins_dir').'/sfReviewPlugin/modules/sfReviewFront/lib/BasesfReviewFrontActions.class.php');

class sfReviewFrontActions extends BasesfReviewFrontActions
{
	private function clearCache( $politico ) {
	  	$cacheManager = $this->getContext()->getViewCacheManager();
	  	if ($cacheManager != null) {
	    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."&sf_culture=es");
	    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."&sf_culture=ca");
	  	}
	}
	
	private function updateSums(sfWebRequest $request) {
	  	// Actualizar cache y puntos en politicos
	  	if ($request->getParameter("t") == Politico::NUM_ENTITY){
		  	$this->politico = PoliticoPeer::retrieveByPk($request->getParameter('e'));
		  	$this->politico->setSumu( $this->politico->getPositives() );
		  	$this->politico->setSumd( $this->politico->getNegatives() );
		  	if ($this->politico->isModified()){
		  		PoliticoPeer::doUpdate( $this->politico );
		  	}
		  	
		  	$this->clearCache( $this->politico );
	  	}
	  	else if($request->getParameter("t") == '') {
		  	$review = SfReviewPeer::retrieveByPk($request->getParameter('e'));
		  	if ($review->getSfReviewType()->getId() == Politico::NUM_ENTITY){
		  		$politico = PoliticoPeer::retrieveByPk($review->getEntityId());
		  		$this->clearCache( $politico );
		  	}
	  	}
	  	
	}
	
  public function executeInit(sfWebRequest $request)
  {
  	parent::executeInit( $request );
  	
  	$t = $request->getParameter("t");
	if($t == ''){
  		return "SimpleSuccess";
   	}
  }
	
  public function executeSend(sfWebRequest $request)
  {  	
  	parent::executeSend( $request );
  	
	$this->updateSums( $request );
  	if($request->getParameter("t") == '') {
	  	$review = SfReviewPeer::retrieveByPk($request->getParameter('e'));
	  	if ($review->getSfReviewType()->getId() == Politico::NUM_ENTITY){
	  		// Enviar email
			$mailBody = $this->getPartial('reviewLeftMailBody', array(
			  'nombre' => $review->getSfGuardUser()->getProfile()->getNombre(),
			  'politico' => 'politico',
			  'comentario' => $request->getParameter("review_text")
			));
	  		//VoMail::send('Respuesta a tu comentario', $mailBody, $review->getSfGuardUser()->getUsername(), 'no-reply@voota.es', true);
	  	}
	}	  	
  }
	  public function executeDelete(sfWebRequest $request)
  {
  	parent::executeDelete( $request );
  	
	$this->updateSums( $request );  	  	
  }
  
  protected function prepareRedirect( $entityId, $type ){
  	if ($type == ''){
  		$review = SfReviewPeer::retrieveByPk($entityId);
  		$this->getUser()->setAttribute('review_c', $entityId);
  		if ($review->getSfReviewTypeId() == 1){
		  	$politico = PoliticoPeer::retrieveByPK( $review->getEntityId() );
	  	}
  	}
  	else if ($type == 1){
  		$politico = PoliticoPeer::retrieveByPK( $entityId );
  	}
  		
  	$culture = $this->getRequest()->getParameter("sf_culture");
  	$rule = "@politico_$culture";
  	$url = "$rule?id=" . $politico->getVanity();		
  	$this->getUser()->setAttribute('url_back', $url);
  	$this->getUser()->setAttribute('review_v', $this->reviewValue);
  	$this->getUser()->setAttribute('review_e', $this->reviewEntityId);
  }
}

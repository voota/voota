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
  	public function executeForm(sfWebRequest $request){
  		parent::executeForm( $request );
		if( $this->getUser()->isAuthenticated() ){
		  	$this->getUser()->setAttribute('url_back', '');
		  	
		  	$this->getUser()->setAttribute('review_v', '');
		  	$this->getUser()->setAttribute('review_e', '');
		  	$this->getUser()->setAttribute('review_text', '');
		  	$this->getUser()->setAttribute('review_c', '');		  	
		}
  	}
  	
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
	// Enviar email
	if($request->getParameter("t") == '') {
	  	$review = SfReviewPeer::retrieveByPk($request->getParameter('e'));
	  	//echo $request->getParameter('i');
	  	$user = $review->getsfGuardUser();
	  	if ($user->getProfile()->getMailsComentarios()){
		  	if ($review->getSfReviewTypeId() == Politico::NUM_ENTITY){
			  	$politico = PoliticoPeer::retrieveByPK( $review->getEntityId() );
		  		$user->getProfile()->setCodigo( util::generateUID() );
		  		$user->getProfile()->save();
				$mailBody = $this->getPartial('reviewLeftMailBody', array(
				  'nombre' => $user->getProfile()->getNombre()
				  , 'usuario' => $this->getUser()->getProfile()->getNombre() . ' ' . $this->getUser()->getProfile()->getApellidos()
				  , 'politico' => $politico->getNombre() . ' ' . $politico->getApellidos()
				  , 'texto_ori' => $review->getText()
				  , 'comentario' => $request->getParameter('review_text')
				  , 'vanity' => $politico->getVanity()
				  , 'codigo' => $user->getProfile()->getCodigo()
				));
				
		  		VoMail::send(
		  			sfContext::getInstance()->getI18N()->__('Tu vooto sobre %1% tiene un comentario', array('%1%' => $politico->getNombre() . ' ' . $politico->getApellidos()))
		  			, $mailBody
		  			, $user->getUsername()
		  			, array('no-reply@voota.es' => 'no-reply Voota')
		  			, true
		  		);
		  		
		  	}
	  	}
	}	  	
  }
  
  public function executeDelete(sfWebRequest $request)
  {
  	parent::executeDelete( $request );
  	
	$this->updateSums( $request );  	  	
  }
  
  protected function prepareRedirect($entityId, $type){
  	$culture = $this->getRequest()->getParameter("sf_culture");
  	$rule = "@politico_$culture";
  	if ($type == ''){
  		$review = SfReviewPeer::retrieveByPk($entityId);
  		$this->getUser()->setAttribute('review_c', $entityId);
  		if ($review->getSfReviewTypeId() == 1){
		  	$politico = PoliticoPeer::retrieveByPK( $review->getEntityId() );
  			$url = "$rule?id=" . $politico->getVanity();
  			$url .= "#subreviews_box$entityId";
  		}
  	}
  	else if ($type == 1){
  		$politico = PoliticoPeer::retrieveByPK( $entityId );
  		$url = "$rule?id=" . $politico->getVanity();		
  	}
  	$this->getUser()->setAttribute('url_back', $url);
  	
  	$this->getUser()->setAttribute('review_v', $this->reviewValue);
  	$this->getUser()->setAttribute('review_e', $this->reviewEntityId);
  	
  	$this->getUser()->setFlash('notice_type', 'warning', true);
    $this->getUser()->setFlash(
    	'notice', 
		sfContext::getInstance()->getI18N()->__('Quieto parao. Para Vootar necesitas tener una cuenta en Voota. Si no tienes cuenta aun, este es el mejor momento!', array(), 'notices')
		, true
	);
  }
}

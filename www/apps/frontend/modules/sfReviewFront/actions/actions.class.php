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
require_once(sfConfig::get('sf_lib_dir').'/vendor/symfony/lib/helper/DateHelper.php');

class sfReviewFrontActions extends BasesfReviewFrontActions
{
  
  public function executeList(sfWebRequest $request)
  {
	$this->page = $request->getParameter("page", "1");
	$this->entityId = $request->getParameter("entityId", false);
	$this->value = $request->getParameter("value", false);
	$this->sfReviewType = $request->getParameter("type_id", false);	
	$this->text = $request->getParameter("t", false);	
	$this->entity = false;
	$this->filter = false;
  	$culture = $this->getUser()->getCulture();
	
	$filter = array();
	$filter['culture'] = $culture;
	if ($this->sfReviewType){
		$filter['type_id'] = ($this->sfReviewType == 'r')?'null':$this->sfReviewType;
	}
	if ($this->text){
		$filter['textFilter'] = 'text';
	}
  	$this->reviewsPager = SfReviewManager::getReviews($filter, $this->page);
  	
  	$filter = array();
	$filter['culture'] = $culture;
  	$filter['type_id'] = Politico::NUM_ENTITY;
  	$this->politicoReviewCount = SfReviewManager::getReviewsCount($filter, $this->page);
  	$filter = array();
	$filter['culture'] = $culture;
  	$filter['type_id'] = Partido::NUM_ENTITY;
  	$this->partidoReviewCount = SfReviewManager::getReviewsCount($filter, $this->page);
  	$filter = array();
	$filter['culture'] = $culture;
  	$filter['type_id'] = Propuesta::NUM_ENTITY;
  	$this->propuestaReviewCount = SfReviewManager::getReviewsCount($filter, $this->page);
  	
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(SfGuardUserPeer::ID);
  	$c->setLimit( 10 );
  	$this->lastUsers = SfGuardUserPeer::doSelect( $c );
  	
  	// Metas
  	$this->title = sfContext::getInstance()->getI18N()->__("Últimas opiniones%1% en Voota.", array(
  		'%1%' => $this->sfReviewType?(sfContext::getInstance()->getI18N()->__("sobre %1%", array('%1%' => ''))):''
  	));  	
  	$this->response->setTitle( $this->title );  	
  	$description = "[autor última opinión] (hace 38 minutos), [autor2] (hace 45 minutos), [autor3] (hace 2 horas), ...";
    $this->response->addMeta('Description', $description);  	
  }

	public function executeShow(sfWebRequest $request){
		parent::executeShow( $request );
		
		$entityText = '';
		if( $this->review->getSfReviewTypeId() ){
			$entityText = $this->entity;
		}
	  	$this->title = sfContext::getInstance()->getI18N()->__('Opinión de %1% sobre %2%'
	  					, array(
	  						'%1%' => $this->review->getSfGuardUser(), 
	  						'%2%' => $entityText?$entityText:sfContext::getInstance()->getI18N()->__('Otro comentario')
	  					)
	  	);
  	
  		$description = sfContext::getInstance()->getI18N()->__('Opinión de %1% sobre %2%. %3%'
	  					, array(
	  						'%1%' => $this->review->getSfGuardUser(), 
	  						'%2%' => $entityText?$entityText:sfContext::getInstance()->getI18N()->__('Otro comentario'),
	  						'%3%' => $this->review->getText()?$this->review->getText():''
	  					)
	  	);
	  	
	  	$description = sfContext::getInstance()->getI18N()->__("%1%publicado por %2% sobre %3% el %4%"
	  					, array(
	  						'%1%' => $this->review->getText()?(SfVoUtil::cutToLength($this->review->getText(), 60, '...', true).', '):'', 
	  						'%2%' => $this->review->getSfGuardUser(),
	  						'%3%' => $entityText?$entityText:sfContext::getInstance()->getI18N()->__('Otro comentario'),
	  						'%4%' => format_date( $this->review->getCreatedAt(), 'd' )
	  					)
	  	);
	    $this->response->addMeta('Description', $description);
  	
    	$this->response->setTitle( $this->title );
 	}
	
  	public function executeForm(sfWebRequest $request){
		if( $this->getUser()->isAuthenticated() ){
		  	$this->getUser()->setAttribute('url_back', '');
		  	
		  	$this->getUser()->setAttribute('review_v', '');
		  	$this->getUser()->setAttribute('review_e', '');
		  	$this->getUser()->setAttribute('review_text', '');
		  	$this->getUser()->setAttribute('review_c', '');		  	
		}
		
  		return parent::executeForm( $request );
  	}
  	
	private function clearCache( $politico ) {
	  	$cacheManager = $this->getContext()->getViewCacheManager();
	  	if ($cacheManager != null) {
	    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."");
	  	}
	}
  	
	private function clearCachePartido( $partido ) {
	  	$cacheManager = $this->getContext()->getViewCacheManager();
	  	if ($cacheManager != null) {
	  		$cacheManager->remove("partido/show?id=".$partido->getAbreviatura()."");
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
	  	else if ($request->getParameter("t") == Partido::NUM_ENTITY){
	  		$this->partido = PartidoPeer::retrieveByPk($request->getParameter('e'));
	  		$this->partido->setSumu( $this->partido->getPositives() );
		  	$this->partido->setSumd( $this->partido->getNegatives() );
		  	if ($this->partido->isModified()){
		  		PartidoPeer::doUpdate( $this->partido );
		  	}
		  	
		  	$this->clearCachePartido( $this->partido );
	  	}
	  	else if($request->getParameter("t") == '') {
		  	$review = SfReviewPeer::retrieveByPk($request->getParameter('e'));
		  	if ($review->getSfReviewType()->getId() == Politico::NUM_ENTITY){
		  		$politico = PoliticoPeer::retrieveByPk($review->getEntityId());
		  		$this->clearCache( $politico );
		  	}
		  	else if ($review->getSfReviewType()->getId() == Partido::NUM_ENTITY){
		  		$partido = PartidoPeer::retrieveByPk($review->getEntityId());
		  		$this->clearCachePartido( $partido );
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
		  	if (($typeId = $review->getSfReviewTypeId())){
		  		$type = SfReviewTypePeer::retrieveByPK( $typeId );
		  		$peer = $type->getModule(). 'Peer';
			  	$entity = $peer::retrieveByPK( $review->getEntityId() );
		  		$user->getProfile()->setCodigo( util::generateUID() );
		  		$user->getProfile()->save();
				$mailBody = $this->getPartial('reviewLeftMailBody', array(
				  'nombre' => $user->getProfile()->getNombre()
				  , 'usuario' => $this->getUser()->getProfile()->getNombre() . ' ' . $this->getUser()->getProfile()->getApellidos()
				  , 'entity' => $typeId == Propuesta::NUM_ENTITY?"\"$entity\"":$entity
				  , 'texto_ori' => $review->getText()
				  , 'comentario' => $request->getParameter('review_text')
				  , 'vanity' => $entity->getVanity()
				  , 'codigo' => $user->getProfile()->getCodigo()
				  , 'voto' => $request->getParameter('v')
				  , 'module' => $entity->getModule()
				));
				
		  		VoMail::send(
		  			sfContext::getInstance()->getI18N()->__('Tu vooto sobre %1% tiene un comentario', array('%1%' => $entity))
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
  		if ($review->getSfReviewTypeId() == Politico::NUM_ENTITY){
		  	$politico = PoliticoPeer::retrieveByPK( $review->getEntityId() );
  			$url = "politico/show?id=" . $politico->getVanity();
  			$url .= "#subreviews_box$entityId";
  		}
  		else if ($review->getSfReviewTypeId() == Partido::NUM_ENTITY){
		  	$partido = PartidoPeer::retrieveByPK( $review->getEntityId() );
  			$url = "partido/show?id=" . $partido->getAbreviatura();
  			$url .= "#subreviews_box$entityId";
  		}
  	}
  	else if ($type == Politico::NUM_ENTITY){
  		$politico = PoliticoPeer::retrieveByPK( $entityId );
  		$url = "politico/show?id=" . $politico->getVanity();		
  	}
  	else if ($type == Partido::NUM_ENTITY){
  		$partido = PartidoPeer::retrieveByPK( $entityId );
  		$url = "partido/show?id=" . $partido->getAbreviatura();		
  	}
  	$this->getUser()->setAttribute('url_back', $url);
  	
  	$this->getUser()->setAttribute('review_v', $this->reviewValue);
  	$this->getUser()->setAttribute('review_e', $this->reviewEntityId);
  	
  	$this->getUser()->setFlash('notice_type', 'warning', true);
  	/*
    $this->getUser()->setFlash(
    	'notice', 
		sfContext::getInstance()->getI18N()->__('Quieto parao. Para Vootar necesitas tener una cuenta en Voota. Si no tienes cuenta aun, este es el mejor momento!', array(), 'notices')
		, true
	);
	*/
	
	$this->redirect('@sf_guard_signin');
  }
}

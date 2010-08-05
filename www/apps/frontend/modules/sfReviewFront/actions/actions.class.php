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
require_once(sfConfig::get('sf_lib_dir').'/helper/VoUserHelper.php');
require_once(sfConfig::get('sf_plugins_dir').'/sfReviewPlugin/lib/helper/SfReviewHelper.php');

class sfReviewFrontActions extends BasesfReviewFrontActions
{

  public function executeListPage(sfWebRequest $request)
  {
	$this->page = $request->getParameter("page", "1");
	$this->sfReviewType = $request->getParameter("type_id", false);	
	$this->text = $request->getParameter("t", false);	
		
	$filter = array();
	if ($this->sfReviewType)
		$filter['type_id'] = $this->sfReviewType;
	if ($this->text)
		$filter['textFilter'] = $this->text;
			
	$this->reviewsPager = SfReviewManager::getReviews($filter, $this->page);
  }
  
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
	$this->culture = $culture;
	
	$filter = array();
	$filter['culture'] = $culture;
	if ($this->sfReviewType){
		$filter['type_id'] = $this->sfReviewType;
	}
	if ($this->text){
		$filter['textFilter'] = 'text';
	}
  	$reviewsPager = SfReviewManager::getReviews($filter, $this->page);
  	
  	$filter = array();
  	$filter['type_id'] = Politico::NUM_ENTITY;
  	$this->politicoReviewCount = SfReviewManager::getReviewsCount($filter, $this->page);
  	$filter = array();
  	$filter['type_id'] = Partido::NUM_ENTITY;
  	$this->partidoReviewCount = SfReviewManager::getReviewsCount($filter, $this->page);
  	$filter = array();
  	$filter['type_id'] = Propuesta::NUM_ENTITY;
  	$this->propuestaReviewCount = SfReviewManager::getReviewsCount($filter, $this->page);
  	
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(SfGuardUserPeer::ID);
  	$c->add(SfGuardUserPeer::IS_ACTIVE, true);
  	$c->setLimit( 10 );
  	$this->lastUsers = SfGuardUserPeer::doSelect( $c );
  	
  	$str = '';
  	switch($this->sfReviewType){
  		case 1:
  			$str = sfContext::getInstance()->getI18N()->__("políticos");
  			break;
  		case 2:
  			$str = sfContext::getInstance()->getI18N()->__("partidos");
  			break;
  		case 3:
  			$str = sfContext::getInstance()->getI18N()->__("propuestas");
  			break;
  		case "null":
  			$str = sfContext::getInstance()->getI18N()->__("respuestas a otros comentarios");
  			break;
  	} 	
  	// Metas
  	$this->title = sfContext::getInstance()->getI18N()->__("Últimas opiniones%1% en Voota.", array(
  		'%1%' => $str?" ". sfContext::getInstance()->getI18N()->__("sobre")." $str":""
  	));  
  	$this->response->setTitle( $this->title ); 
  	$reviews = $reviewsPager->getResults();
  	
  	$description = 
  		($reviews[0]->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):(trim($reviews[0]->getSfGuardUser())?$reviews[0]->getSfGuardUser():$reviews[0]->getSfGuardUser()->getProfile())).
  		" (".ago(strtotime( $reviews[0]->getModifiedAt()?$reviews[0]->getModifiedAt():$reviews[0]->getCreatedAt() ))."), ".
  		($reviews[1]->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):(trim($reviews[1]->getSfGuardUser())?$reviews[1]->getSfGuardUser():$reviews[1]->getSfGuardUser()->getProfile())).
  		" (".ago(strtotime( $reviews[1]->getModifiedAt()?$reviews[1]->getModifiedAt():$reviews[1]->getCreatedAt() ))."), ".
  		($reviews[2]->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):(trim($reviews[2]->getSfGuardUser())?$reviews[2]->getSfGuardUser():$reviews[2]->getSfGuardUser()->getProfile())).
  		" (".ago(strtotime( $reviews[2]->getModifiedAt()?$reviews[2]->getModifiedAt():$reviews[2]->getCreatedAt() ))."), ".
  		"...";  	
  		
    $this->response->addMeta('Description', $description);  	
    
    // Feed
    $request->setAttribute('rssTitle',  $this->title. " Feed RSS");
    $params = "";
    if ($this->sfReviewType){
    	$params .= ($params?'&':'?').'type_id='.$this->sfReviewType;
    }
    if ($this->text){
    	$params .= ($params?'&':'?').'t='.$this->text;
    }
    $request->setAttribute('rssFeed',  "sfReviewFront/feed$params");
  }
  
  public function executeFeed(sfWebRequest $request)
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
	//$filter['culture'] = $culture;
	if ($this->sfReviewType){
		$filter['type_id'] = $this->sfReviewType;
	}
	if ($this->text){
		$filter['textFilter'] = 'text';
	}
  	$reviewsPager = SfReviewManager::getReviews($filter);

  	$str = '';
  	switch($this->sfReviewType){
  		case 1:
  			$str = sfContext::getInstance()->getI18N()->__("políticos");
  			break;
  		case 2:
  			$str = sfContext::getInstance()->getI18N()->__("partidos");
  			break;
  		case 3:
  			$str = sfContext::getInstance()->getI18N()->__("propuestas");
  			break;
  		case "null":
  			$str = sfContext::getInstance()->getI18N()->__("respuestas a otros comentarios");
  			break;
  	}
  	$title = sfContext::getInstance()->getI18N()->__("Últimas opiniones%1% en Voota.", array(
  		'%1%' => $str?" ". sfContext::getInstance()->getI18N()->__("sobre")." $str":""
  	));  	
  	$reviews = $reviewsPager->getResults();
  	
  	$description = 
  		($reviews[0]->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):(trim($reviews[0]->getSfGuardUser())?$reviews[0]->getSfGuardUser():$reviews[0]->getSfGuardUser()->getProfile())).
  		" (".ago(strtotime( $reviews[0]->getModifiedAt()?$reviews[0]->getModifiedAt():$reviews[0]->getCreatedAt() ))."), ".
  		($reviews[1]->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):(trim($reviews[1]->getSfGuardUser())?$reviews[1]->getSfGuardUser():$reviews[1]->getSfGuardUser()->getProfile())).
  		" (".ago(strtotime( $reviews[1]->getModifiedAt()?$reviews[1]->getModifiedAt():$reviews[1]->getCreatedAt() ))."), ".
  		($reviews[2]->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):(trim($reviews[2]->getSfGuardUser())?$reviews[2]->getSfGuardUser():$reviews[2]->getSfGuardUser()->getProfile())).
  		" (".ago(strtotime( $reviews[2]->getModifiedAt()?$reviews[2]->getModifiedAt():$reviews[2]->getCreatedAt() ))."), ".
  		"...";  
  		
    $feed = new sfRssFeed();
    $feed->setTitle( $title );
    $feed->setLanguage( $culture );
    $feed->setSubtitle( $description );
    $feed->setDescription( $description );
    $params = "";
    if ($this->sfReviewType){
    	$params .= ($params?'&':'?').'type_id='.$this->sfReviewType;
    }
    if ($this->text){
    	$params .= ($params?'&':'?').'t='.$this->text;
    }
  	$feed->setLink("sfReviewFront/feed$params");
  	$domainExt = $culture == 'ca'?"cat":$culture;
  	$feed->setAuthorName("Voota.$domainExt");

  	foreach ($reviews as $review){
	    $item = new sfFeedItem();
	    
	    $entityText = "";
	    if (!$review->getSfReviewType()){
	    	$tmpReview = $review->getSfReviewRelatedBySfReviewId();
	    	$entityText = sfContext::getInstance()->getI18N()->__('otra opinión sobre'). ' ';
	    }
	    else {
	    	$tmpReview = $review;
	    } 
	    $sfReviewType = SfReviewTypePeer::retrieveByPk($tmpReview->getSfReviewTypeId());
	    $peer = $sfReviewType->getModel() . 'Peer';
	    $entity = $peer::retrieveByPk( $tmpReview->getEntityId() );
	    $entityText .= $entity;
	    $item->setTitle(sfContext::getInstance()->getI18N()->__('%1%, voota %2% de %3%.', array(
	    	'%1%' => $review->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):$review->getSfGuardUser(), 
	    	'%2%' => $review->getValue()==-1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'),
	    	'%3%' => $entityText
	    )));
	    $item->setLink('sfReviewFront/show?id='.SfVoUtil::reviewPermalink($review));
	    if (!$review->getAnonymous())
	    	$item->setAuthorName($review->getSfGuardUser());
	    $item->setPubdate($review->getCreatedAt('U'));
	    $item->setUniqueId($review->getId());
	    
	    if (!$review->getAnonymous())
	    	$avatar = S3Voota::getImagesUrl().'/usuarios/cc_s_'.$review->getSfGuardUser()->getProfile()->getImagen();
	    $text = ($culture==$review->getCulture()|| !$review->getCulture())?$review->getText():'';
	    if (!$review->getAnonymous())
	    	$img = $review->getSfGuardUser()->getProfile()->getImagen()?"<img src=\"$avatar\" alt =\"".$review->getSfGuardUser()."\" /> ":"";
	    $content =  "$text"; 
	    
	    $item->setDescription( $content );
	
	    $feed->addItem($item);
	}
  	
  	$this->feed = $feed;
  }

	public function executeShow(sfWebRequest $request){
		parent::executeShow( $request );
		
		$entityText = '';
		if( $this->review->getSfReviewTypeId() ){
			$entityText = $this->entity;
		}
	  	$this->title = sfContext::getInstance()->getI18N()->__('Opinión de %1% sobre %2%'
	  					, array(
	  						'%1%' => $this->review->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):$this->review->getSfGuardUser(), 
	  						'%2%' => $entityText?$entityText:sfContext::getInstance()->getI18N()->__('Otro comentario')
	  					)
	  	);
  	
  		$description = sfContext::getInstance()->getI18N()->__('Opinión de %1% sobre %2%. %3%'
	  					, array(
	  						'%1%' => $this->review->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):$this->review->getSfGuardUser(), 
	  						'%2%' => $entityText?$entityText:sfContext::getInstance()->getI18N()->__('Otro comentario'),
	  						'%3%' => $this->review->getText()?$this->review->getText():''
	  					)
	  	);
	  	
	  	$description = sfContext::getInstance()->getI18N()->__("%1%publicado por %2% sobre %3% el %4%"
	  					, array(
	  						'%1%' => $this->review->getText()?(SfVoUtil::cutToLength($this->review->getText(), 60, '...', true).', '):'', 
	  						'%2%' => $this->review->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo'):$this->review->getSfGuardUser(),
	  						'%3%' => $entityText?$entityText:sfContext::getInstance()->getI18N()->__('Otro comentario'),
	  						'%4%' => format_date( $this->review->getCreatedAt(), 'd' )
	  					)
	  	);
	    $this->response->addMeta('Description', $description);
  	
    	$this->response->setTitle( $this->title );
 	}
	
  	public function executeForm(sfWebRequest $request){
		if( $this->getUser()->isAuthenticated() ){
		  	$this->getUser()->setAttribute('url_back', '', 'vo/redir');
		  	
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
	
  public function sendTasks(sfWebRequest $request)
  {  	  	
  	$tw_publish = $request->getParameter("tw_publish", 0);
  	$t = $request->getParameter("t", false);
  	$v = $request->getParameter("v", false);
  	$e = $request->getParameter("e", false);
  	$review_text = $request->getParameter("review_text", false);
  	
	$this->updateSums( $request );
	
	if ($t){
		$type = SfReviewTypePeer::retrieveByPk( $t );
		$peer = $type->getModel(). "Peer";
		$entity = call_user_func  ("$peer::retrieveByPk" , $e);		
	}
	else {
	  	$review = SfReviewPeer::retrieveByPk($request->getParameter('e'));
	  	if (($typeId = $review->getSfReviewTypeId())){
	  		$type = SfReviewTypePeer::retrieveByPK( $typeId );
	  		$peer = $type->getModule(). 'Peer';
		  	$entity = call_user_func  ("$peer::retrieveByPk" , $review->getEntityId());
	  	}		
	}
  
  	$msg = "";
  	if($tw_publish && TwitterManager::verify( $this->getUser() )){
  		switch($t){
  			case Politico::NUM_ENTITY:
  				$entityUrl = sfContext::getInstance()->getController()->genUrl("politico/show?id=".$entity->getVanity(), true);
  				
  				$msg = sfContext::getInstance()->getI18N()->__('Voto  %1% de %2% en @Voota:  %3%', array(
  						'%1%' => $v == -1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'),
  						'%2%' => $entity,
  						'%3%' => TwitterManager::shorten($entityUrl)
  					)
  				);
  				break;
  			case Partido::NUM_ENTITY:
  				$entityUrl = sfContext::getInstance()->getController()->genUrl("partido/show?id=".$entity->getAbreviatura(), true);
  				
  				$msg = sfContext::getInstance()->getI18N()->__('Voto %1% del partido %2% en @Voota: %3%', array(
  						'%1%' => $v == -1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'),
  						'%2%' => $entity->getAbreviatura(),
  						'%3%' => TwitterManager::shorten($entityUrl)
  					)
  				);
  				break;
  			case Propuesta::NUM_ENTITY:
  				$entityUrl = sfContext::getInstance()->getController()->genUrl("propuesta/show?id=".$entity->getVanity(), true);
  				
  				$msg = sfContext::getInstance()->getI18N()->__('Voto %1% de la propuesta "%2%" en @Voota: %3%', array(
  						'%1%' => $v == -1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'),
  						'%2%' => SfVoUtil::cutToLength($entity->getTitulo(), 60, '...', true),
  						'%3%' => TwitterManager::shorten($entityUrl)
  					)
  				);
  				break;
  			case "":
  				$entityUrl = sfContext::getInstance()->getController()->genUrl($type->getModule()."/show?id=".$entity->getVanity(), true);
  				
  				$msg = sfContext::getInstance()->getI18N()->__('Vooto %1% de una opinión sobre %2% en @Voota: %3%', array(
  						'%1%' => $v == -1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'),
  						'%2%' => $entity,
  						'%3%' => TwitterManager::shorten($entityUrl)
  					)
  				);
  				break;
  		}
  		TwitterManager::post( $this->getUser(), $msg );
  	}
  	
	// Enviar email
	if(! $t) {
	  	//echo $request->getParameter('i');
	  	$user = $review->getsfGuardUser();
	  	if ($user->getProfile()->getMailsComentarios()){
		  	if ($typeId){
		  		$user->getProfile()->setCodigo( util::generateUID() );
		  		$user->getProfile()->save();
				$mailBody = $this->getPartial('reviewLeftMailBody', array(
				  'nombre' => $user->getProfile()->getNombre()
				  , 'usuario' => $review->getAnonymous()?sfContext::getInstance()->getI18N()->__('anónimo (está en su derecho)'):($this->getUser()->getProfile()->getNombre() . ' ' . $this->getUser()->getProfile()->getApellidos())
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
  
  public function executeFilteredActivities(sfWebRequest $request)
  {
  	$this->entityId = $request->getParameter("entityId");  	
  	$this->value = $request->getParameter("value");  		
  	$this->page = $request->getParameter("page");	
  	$this->sfReviewType = $request->getParameter("sfReviewType");
  	$this->filter = $request->getParameter("filter", false);
  	$this->slot = $request->getParameter("slot", false);
  	$this->userId = $request->getParameter("userId", false);
  	
  	// Estabamos vootando antes del login ?
  	$sfr_status = $this->getUser()->getAttribute('sfr_status', false, 'sf_review');
  	if ($sfr_status){
  		$aSfrStatus = array();
  		foreach ($sfr_status as $key => $value){
  			$aSfrStatus[$key] = $value;
  		}
  		$this->sfr_status = $aSfrStatus;
  		$request->setAttribute('sfr_status', $aSfrStatus);
  		$this->getUser()->setAttribute('sfr_status', false, 'sf_review');
  	}
  	else {
  		$this->getUser()->setAttribute('sfr_status', false, 'sf_review');
  		$this->sfr_status = false;
  	}
  	
  	$c = new Criteria;
  	if ($this->sfReviewType) {
  		$c->add(SfReviewTypePeer::ID, $this->sfReviewType);
  	}
  	$reviewType = SfReviewTypePeer::doSelectOne( $c );
  	if ($reviewType) {
	  	$peer = $reviewType->getModel() .'Peer';
	  	$c = new Criteria;
	  	$c->add($peer::ID, $this->entityId);
	  	$this->entity = $peer::doSelectOne( $c );
  	} 
  	
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Pragma: no-cache');
  }
  
}

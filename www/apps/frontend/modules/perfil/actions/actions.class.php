<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * perfil actions.
 *
 * @package    Voota
 * @subpackage perfil
 * @author     Sergio Viteri
 */

class perfilActions extends SfVoActions
{
	
  public function executeContact(sfWebRequest $request)
  {  
	$this->checkUser();
  	
  	$vanity = $request->getParameter('username');
  	$this->f = $request->getParameter('f');
    
  	$c = new Criteria();
  	$c->add(SfGuardUserProfilePeer::VANITY, $vanity, Criteria::EQUAL);
  	$userProfile = SfGuardUserProfilePeer::doSelectOne( $c );
  	$this->forward404Unless($userProfile);
  	
  	$this->user = $userProfile->getsfGuardUser();  
    $this->form = new UserContactForm();	
  	
    if ( $request->isMethod('post') ) {
      $this->form->bind($request->getParameter('contact'));
      
      if ( $this->form->isValid() ) {
      	if ( $this->user->getProfile()->getMailsContacto() == 1 ) {
	      	$codigo = util::generateUID();
			$this->user->getProfile()->setCodigo( $codigo );
			$this->user->getProfile()->save();
			  	
	      	$mailBody = $this->getPartial('contactMailBody', array(
			  	'destinatario' => $this->user->getProfile()->getNombre(),
			  	'remitente' => $this->getUser()->getProfile()->getNombre(),
			  	'cuerpo' => $this->form->getValue('mensaje'),
				'vanity' => $this->getUser()->getProfile()->getVanity(),
				'codigo' => $codigo
			));
				
	      	try {
				      	
				VoMail::sendWithRet("Tienes un mensaje de ".$this->getUser()->getProfile()->getNombre()."", $mailBody, $this->user->getUsername(), array('no-reply@voota.es' => 'no-reply Voota'), $this->getUser()->getUsername(), true);
				
				return "SendSuccess";
	      	}
	      	catch (Exception $e){
	      		return "SendFail";      		
	      	}
      	}
      	else {
	      	return "SendFail";      		
      	}
      }
	  return "SendSuccess";
    }
  }
  
  public function executeReviews(sfWebRequest $request)
  {
  	$op = $request->getParameter('o');
  	$this->f = $request->getParameter('f');
  	$culture = $this->getUser()->getCulture();
	$this->sfReviewType = $request->getParameter("type_id", false);	
	$this->text = $request->getParameter("t", false);	
  		
  	$this->forward404Unless($this->getUser()->getGuardUser());
  	
  	$c = new Criteria();
  	$c->add(PropuestaPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());
  	$c->addDescendingOrderByColumn('created_at');
  	$this->propuestas = PropuestaPeer::doSelect( $c );
  	
  	if ($op == 'v' || $op == 'e'){
  		$t = $request->getParameter('t');
  		$e = $request->getParameter('e');
  		$r = $request->getParameter('r');
  		if ($t == ''){
		  	$review = SfReviewPeer::retrieveByPk($e);
  			
		  	$type = $review->getSfReviewType();
  			$peer = $type->getModel() . 'Peer';
  			
		  	$c = new Criteria();
		  	$c->addJoin($peer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
		  	$c->add(SfReviewPeer::ID, $e);
		  	
		  	$entity = $peer::doSelectOne($c);
  			$dest = $type->getModule()."/show?id=".$entity->getVanity();
		}
  		else {
  			$type = SfReviewTypePeer::retrieveByPk( $t );
  			$peer = $type->getModel() . 'Peer';
  			
			$entity = $peer::retrieveByPK($e);
  			$dest = $type->getModule()."/show?id=".$entity->getVanity();   			
   		}
   		
   		
	  	if ($op == 'e'){
	  		$this->getUser()->setAttribute('review_v', 1);
	  		$this->getUser()->setAttribute('review_e', $entity->getId());
	  		$this->getUser()->setAttribute('review_c', $e);
	  	}
	  	
  		if ($t == ''){
	  		$dest .= "#subreviews_box$e";
  		}
  		else {
	  		if ($op == 'v'){
  				$dest .= "#sf_review_c_m$r";
	  		}
  		}

  		$this->redirect( $dest );
  	}
  	
  	if (! $this->getUser()->isAuthenticated() ) {
  	$this->getUser()->setFlash('notice_type', 'warning', true);
	    $this->getUser()->setFlash(
	    	'notice', 
			sfContext::getInstance()->getI18N()->__('¿Nuevo por aquí? Necesitas tener una cuenta Voota (o en Facebook) para continuar. Tu vooto será público o secreto, como gustes.', array())
			, true
		);
  		$this->getUser()->setAttribute('url_back', '@usuario_votos', 'vo/redir');
  	}
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );

    $this->reviews = SfReviewManager::getReviewsByUser($this->getUser()->getGuardUser()->getId(), $this->f);
    
    $this->user = $this->getUser()->getGuardUser();
  }
  public function executeShow(sfWebRequest $request)
  {
  	$vanity = $request->getParameter('username');
  	$this->f = $request->getParameter('f');
  	$culture = $this->getUser()->getCulture();
	$this->sfReviewType = $request->getParameter("type_id", false);	
	$this->text = $request->getParameter("t", false);	
    
  	$c = new Criteria();
  	$c->add(SfGuardUserProfilePeer::VANITY, $vanity, Criteria::EQUAL);
  	$userProfile = SfGuardUserProfilePeer::doSelectOne( $c );
  	$this->forward404Unless($userProfile);
  	$this->user = $userProfile->getsfGuardUser();
  	if (!$this->user->getIsActive() && is_numeric($userProfile->getFacebookUid()) ){
  		$user = SfGuardUserPeer::retrieveByPK($userProfile->getFacebookUid());
  		$this->forward404Unless( $user );
  		$this->redirect('perfil/show?username='. $user->getProfile()->getVanity(), 301);
  	}
  	$this->forward404Unless($this->user->getIsActive());
  	
  
  	if ($this->user->getProfile()->getVanity() != $vanity || $this->f){
  		$this->redirect('perfil/show?username='.$this->user->getProfile()->getVanity(), 301);
  	}
  	
  	$c = new Criteria();
  	$c->add(EnlacePeer::SF_GUARD_USER_ID, $userProfile->getUserId());
  	$c->add(EnlacePeer::URL, '', Criteria::NOT_EQUAL);
  	$this->enlaces = EnlacePeer::doSelect( $c );
  	
  	$c = new Criteria();
  	$c->add(PropuestaPeer::SF_GUARD_USER_ID, $userProfile->getUserId());
  	$c->addDescendingOrderByColumn('created_at');
  	$this->propuestas = PropuestaPeer::doSelect( $c );
  	
    //$this->reviews = SfReviewManager::getReviewsByUser($this->user->getId(), $this->f);
    $filterText = '';
    switch($this->sfReviewType){
    	case '1':
    		$filterText = sfContext::getInstance()->getI18N()->__('políticos');
    		break;
    	case '2':
    		$filterText = sfContext::getInstance()->getI18N()->__('partidos');
    		break;
    	case '3':
    		$filterText = sfContext::getInstance()->getI18N()->__('propuestas políticas');
    		break;
    	case 'null':
    		$filterText = sfContext::getInstance()->getI18N()->__('otros comentarios');
    		break;
    }
    
    //if (!$filterText){
	    $this->title = sfContext::getInstance()->getI18N()->__('Página de usuario de %1% en Voota', array(
	    	'%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity()
	    )); 
    /*}
    else {
	    $this->title = sfContext::getInstance()->getI18N()->__('Opiniones de %1% sobre %2% en Voota', array(
	    	'%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity()
	    	, '%2%' => $filterText
	    )); 
    }*/
    $this->response->setTitle( $this->title );
    
    $filter = array();
	if (isset($this->sfReviewType)){
		$filter['type_id'] = $this->sfReviewType;
		$filter['textFilter'] = $this->text?'text':false;
		$filter['userId'] = $userProfile->getUserId();
		$filter['culture'] = $culture;
	}

	$this->reviewsPager = SfReviewManager::getReviews($filter, 1, 3);
	
    //if (!$filterText){
	    $descripcion = SfVoUtil::cutToLength($userProfile->getPresentacion(), 155, '...', true);
    /*}
    else {
			
    	if ($this->reviewsPager->getNbResults() == 0){
		    $descripcion = sfContext::getInstance()->getI18N()->__('%1% aún no se ha animado a comentar', trim($this->user)?$this->user:$this->user->getProfile()->getVanity());
       	}   
    	else { 	
		    $descripcion = sfContext::getInstance()->getI18N()->__('%1% ha comentado sobre', array('%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity())). ': ';
		    			    
    		foreach ($this->reviewsPager->getResults() as $idx => $review){
    			$type = $review->getSfReviewTypeId();
	  			if (! $type){
	  				$parentReview = $review->getSfReviewRelatedBySfReviewId();
	  				$aEntityId = $parentReview->getEntityId();
	  				$aTypeId = $parentReview->getSfReviewTypeId();
	  				
	  			}
	  			else {
	  				$aTypeId = $type;
	  				$aEntityId = $review->getEntityId();
	  			}
	  			
	  			$reviewType = SfReviewTypePeer::retrieveByPK ( $aTypeId );
	  			$peer = $reviewType->getModel() .'Peer';
	  			
	  			//$entity = $peer::retrieveByPK($aEntityId);
	  			$entity = call_user_func("$peer::retrieveByPK", $aEntityId);

	  			$descripcion .= ($idx != 0?', ':'').(!$type?sfContext::getInstance()->getI18N()->__('otro comentario sobre'). ' ':'').($aTypeId==Propuesta::NUM_ENTITY?"\"$entity\"":$entity);
	    	}
    	}
    }*/
	$this->response->addMeta('Description', $descripcion?$descripcion:sfContext::getInstance()->getI18N()->__('Votos y opiniones de %1% sobre políticos y partidos de España', array('%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity())) );
    
    // Feed
    $request->setAttribute('rssTitle',  $this->title. " Feed RSS");
    $request->setAttribute('rssFeed',  'perfil/feed?username='.$this->user->getProfile()->getVanity());
  }

  public function executeFeed(sfWebRequest $request)
  {
  	$vanity = $request->getParameter('username');
  	$this->f = $request->getParameter('f');
  	$culture = $this->getUser()->getCulture();
    
  	$c = new Criteria();
  	$c->add(SfGuardUserProfilePeer::VANITY, $vanity, Criteria::EQUAL);
  	$userProfile = SfGuardUserProfilePeer::doSelectOne( $c );
  	$this->forward404Unless($userProfile);
  	$this->user = $userProfile->getsfGuardUser();
  	if (!$this->user->getIsActive() && is_numeric($userProfile->getFacebookUid()) ){
  		$user = SfGuardUserPeer::retrieveByPK($userProfile->getFacebookUid());
  		$this->forward404Unless( $user );
  		$this->redirect('perfil/show?username='. $user->getProfile()->getVanity(), 301);
  	}
  	$this->forward404Unless($this->user->getIsActive());
  	
	$reviews = SfReviewManager::getReviewsByUser($this->user->getId(), $this->f);
  	
  	$title = sfContext::getInstance()->getI18N()->__('%1% en Voota.es'
  					, array(
  						'%1%' => $this->user
  					)
  	);
  	$descripcion = SfVoUtil::cutToLength($userProfile->getPresentacion(), 155, '...', true);
    $description = $descripcion?$descripcion:sfContext::getInstance()->getI18N()->__('Votos y opiniones de %1% sobre políticos y partidos de España', array('%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity()));
  	
  	
    $feed = new sfRssFeed();
    $feed->setTitle( $title );
    $feed->setLanguage( $culture );
    $feed->setSubtitle( $description );
    $feed->setDescription( $description );
  	$feed->setLink('perfil/show?username='.$this->user->getProfile()->getVanity());
  	$domainExt = $culture == 'ca'?"cat":$culture;
  	$feed->setAuthorName("Voota.$domainExt");
  	
  	$feedImage = new sfFeedImage();
	$feedImage->setLink('perfil/show?username='.$this->user->getProfile()->getVanity());
	$feedImage->setImage(S3Voota::getImagesUrl().'/usuarios/cc_'.$this->user->getProfile()->getImagen());
	$feedImage->setTitle( $this->user );
	$feed->setImage($feedImage);
  	
  	
  	foreach ($reviews as $review){
	    $item = new sfFeedItem();
	    
	    $entityText = "";
	    if (!$review->getSfReviewType()){
	    	$tmpReview = $review->getSfReviewRelatedBySfReviewId();
	    	$entityText = sfContext::getInstance()->getI18N()->__('Otra opinión sobre'). ' ';
	    }
	    else {
	    	$tmpReview = $review;
	    } 
	    $sfReviewType = SfReviewTypePeer::retrieveByPk($tmpReview->getSfReviewTypeId());
	    $peer = $sfReviewType->getModel() . 'Peer';
	    $entity = $peer::retrieveByPk( $tmpReview->getEntityId() );
	    $entityText .= $entity;
	    
	    $item->setTitle(sfContext::getInstance()->getI18N()->__('%1%, voota %2%.', array('%1%' => $entityText, '%2%' => $review->getValue()==-1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'))));
	    $item->setLink('sfReviewFront/show?id='.SfVoUtil::reviewPermalink($review));
	    $item->setAuthorName($review->getSfGuardUser());
	    $item->setPubdate($review->getCreatedAt('U'));
	    $item->setUniqueId($review->getId());
	    
	    $avatar = S3Voota::getImagesUrl().'/usuarios/cc_s_'.$review->getSfGuardUser()->getProfile()->getImagen();
	    $text = ($culture==$review->getCulture()|| !$review->getCulture())?$review->getText():'';
	    $img = $review->getSfGuardUser()->getProfile()->getImagen()?"<img src=\"$avatar\" alt =\"".$review->getSfGuardUser()."\" /> ":"";
	    $content =  "$text"; 
	    
	    $item->setDescription( $content );
	
	    $feed->addItem($item);
	}
  	
  	$this->feed = $feed;
  	
  }
  
  public function executeMore(sfWebRequest $request)
  {
  	$vanity = $request->getParameter('username');
  	$culture = $this->getUser()->getCulture();
    $this->page = $request->getParameter("page");  
    if ($this->page) {
    	$this->page += 1;
    }
    else {
    	$this->page = 1;
    }
    
  	$c = new Criteria();
  	$c->add(SfGuardUserProfilePeer::VANITY, $vanity, Criteria::EQUAL);
  	$userProfile = SfGuardUserProfilePeer::doSelectOne( $c );
  	$this->forward404Unless($userProfile);
  	
  	$this->user = $userProfile->getsfGuardUser();
  	/*
  	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	//$criteria->add(SfReviewPeer::CULTURE, $culture);
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $this->user->getId());
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    if ($this->page) {
    	$this->page += 1;
    	$this->reviews->setPage( $this->page );
    }
    else {
    	$this->page = 1;
    }
    $this->reviews->init();
    */
    $this->reviews = SfReviewManager::getReviewsByUser($this->user->getId(), $this->f, $this->page?$this->page:1);
  }
}

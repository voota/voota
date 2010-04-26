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
			sfContext::getInstance()->getI18N()->__('Quieto parao. Para Vootar necesitas tener una cuenta en Voota. Si no tienes cuenta aun, este es el mejor momento!', array(), 'notices')
			, true
		);
  		$this->getUser()->setAttribute('url_back', '@usuario_votos');
  	}
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
  	$criteria = new Criteria();
  	// TODO:
	$criteria->add(SfReviewPeer::CULTURE, $culture);
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $this->getUser()->getGuardUser()->getId());
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	if( $this->f ){
		if (preg_match('/\.0/', $this->f)){
			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, null, Criteria::ISNULL);
		}
		else if (preg_match('/[0-9]/', $this->f)){
			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->f);
		}
		$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	}
	
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    $this->reviews->init();
    
    $this->user = $this->getUser()->getGuardUser();
  }
  public function executeShow(sfWebRequest $request)
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
  	
  	$criteria = new Criteria();
	  $criteria->add(SfReviewPeer::IS_ACTIVE, true);
	  $criteria->add(SfReviewPeer::CULTURE, $culture);
	  $criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $this->user->getId());
	  $criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	if( $this->f ){
		if (preg_match('/\.0/', $this->f)){
			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, null, Criteria::ISNULL);
		}
		else if (preg_match('/[0-9]/', $this->f)){
			$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->f);
		}
		$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	}
	  
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    $this->reviews->init();
    
    $this->response->setTitle( sfContext::getInstance()->getI18N()->__('Página de usuario de %1% en Voota', array('%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity())) );
    $descripcion = SfVoUtil::cutToLength($userProfile->getPresentacion(), 155, '...', true);
    $this->response->addMeta('Description', $descripcion?$descripcion:sfContext::getInstance()->getI18N()->__('Votos y opiniones de %1% sobre políticos y partidos de España', array('%1%' => trim($this->user)?$this->user:$this->user->getProfile()->getVanity())) );
  }
  public function executeMore(sfWebRequest $request)
  {
  	$vanity = $request->getParameter('username');
  	$culture = $this->getUser()->getCulture();
    
  	$c = new Criteria();
  	$c->add(SfGuardUserProfilePeer::VANITY, $vanity, Criteria::EQUAL);
  	$userProfile = SfGuardUserProfilePeer::doSelectOne( $c );
  	$this->forward404Unless($userProfile);
  	
  	$this->user = $userProfile->getsfGuardUser();
  	
  	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
	$criteria->add(SfReviewPeer::CULTURE, $culture);
	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID , $this->user->getId());
	$criteria->addDescendingOrderByColumn("IFNULL(".SfReviewPeer::MODIFIED_AT.",".SfReviewPeer::CREATED_AT.")");
	
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    $this->page = $request->getParameter("page");
    if ($this->page) {
    	$this->page += 1;
    	$this->reviews->setPage( $this->page );
    }
    else {
    	$this->page = 1;
    }
    $this->reviews->init();
  }
}

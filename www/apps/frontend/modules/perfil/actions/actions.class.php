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
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
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
  		
  	if ($op == 'v' || $op == 'e'){
  		$t = $request->getParameter('t');
  		$e = $request->getParameter('e');
  		$r = $request->getParameter('r');
  		if ($t == ''){
		  	$c = new Criteria();
		  	$c->add(SfReviewPeer::ID, $e);
		  	$review = SfReviewPeer::doSelectOne($c);
  			
  			if ($review->getSfReviewType()->getId() == Politico::NUM_ENTITY){
			  	$c = new Criteria();
			  	$c->addJoin(PoliticoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
			  	$c->add(SfReviewPeer::ID, $e);
			  	
			  	$entity = PoliticoPeer::doSelectOne($c);
  				$dest = "politico/show?id=".$entity->getVanity();
  			}
  			else if ($review->getSfReviewType()->getId() == Partido::NUM_ENTITY){
			  	$c = new Criteria();
			  	$c->addJoin(PartidoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
			  	$c->add(SfReviewPeer::ID, $e);
			  	
			  	$entity = PartidoPeer::doSelectOne($c);  	
  				$dest = "partido/show?id=".$entity->getAbreviatura();			
  			}
		}
  		else {
  			if ($t == Politico::NUM_ENTITY){
				$entity = PoliticoPeer::retrieveByPK($e);
  				$dest = "politico/show?id=".$entity->getVanity();
   			}
  			else if ($t == Partido::NUM_ENTITY){
				$entity = PartidoPeer::retrieveByPK($e);
  				$dest = "partido/show?id=".$entity->getAbreviatura();
  			}
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
    
    $this->response->setTitle( sfContext::getInstance()->getI18N()->__('Página de usuario de %1% en Voota', array('%1%' => $this->user?$this->user:$user->getProfile()->getVanity())) );
    $descripcion = SfVoUtil::cutToLength($userProfile->getPresentacion(), 155, '...', true);
    $this->response->addMeta('Description', $descripcion?$descripcion:sfContext::getInstance()->getI18N()->__('Votos a favor y encontra de %1% sobre políticos y partidos de España', array('%1%' => $this->user?$this->user:$user->getProfile()->getVanity())) );
  }
  public function executeMore(sfWebRequest $request)
  {
    
  	$vanity = $request->getParameter('username');
    
  	$c = new Criteria();
  	$c->add(SfGuardUserProfilePeer::VANITY, $vanity, Criteria::EQUAL);
  	$userProfile = SfGuardUserProfilePeer::doSelectOne( $c );
  	$this->forward404Unless($userProfile);
  	
  	$this->user = $userProfile->getsfGuardUser();
  	
  	$criteria = new Criteria();
	$criteria->add(SfReviewPeer::IS_ACTIVE, true);
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

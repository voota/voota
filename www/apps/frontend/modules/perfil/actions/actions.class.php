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

class perfilActions extends sfActions
{

  public function executeReviews(sfWebRequest $request)
  {
  	$op = $request->getParameter('o');
  		
  	if ($op == 'v' || $op == 'e'){
  		$t = $request->getParameter('t');
  		$e = $request->getParameter('e');
  		$r = $request->getParameter('r');
  		if ($t == ''){
		  	$c = new Criteria();
		  	$c->addJoin(PoliticoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
		  	$c->add(SfReviewPeer::ID, $e);
		  	
		  	$politico = PoliticoPeer::doSelectOne($c);
		}
  		else {
			$politico = PoliticoPeer::retrieveByPK($e);
   		}
  		$dest = "politico/show?id=".$politico->getVanity();
	  	if ($op == 'e'){
	  		$this->getUser()->setAttribute('review_v', 1);
	  		$this->getUser()->setAttribute('review_e', $politico->getId());
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
	
  	$this->reviews = new sfPropelPager('SfReview', BaseSfReviewManager::NUM_REVIEWS);
    $this->reviews->setCriteria($criteria);
    $this->reviews->init();
    
    $this->user = $this->getUser()->getGuardUser();
  }
  public function executeShow(sfWebRequest $request)
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
    $this->reviews->init();
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

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
class reviewActions extends sfVoActions
{
  public function executeForm(sfWebRequest $request)
  {
  	$this->reviewValue = $request->getParameter("v");
  	$this->reviewType = $request->getParameter("t");
  	$this->reviewEntityId = $request->getParameter("e");
  	if (! $this->getUser()->isAuthenticated()) {
  		$url = "/".$this->getUser()->getCulture()."/politico/" . $this->reviewEntityId;		
  		$this->getUser()->setAttribute('url_back', $url);
  		$this->getUser()->setAttribute('review_v', $this->reviewValue);
  		$this->getUser()->setAttribute('review_e', $this->reviewEntityId);
  		echo "(<script>document.location='/".$this->getUser()->getCulture()."/user/login'</script>)";die;
  	}
  	
  	$criteria = new Criteria();
  	$criteria->add(SfReviewPeer::ENTITY_ID, $this->reviewEntityId);  	
  	$criteria->add(SfReviewPeer::SF_GUARD_USER_ID, $this->getUser()->getGuardUser()->getId());  	
  	$criteria->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $this->reviewType);  	
  	$review = SfReviewPeer::doSelect($criteria);
  	if ($review) {
  		return sfView::ERROR;
  	}
  }
	
  public function executePreview(sfWebRequest $request)
  {
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	
  	$this->reviewValue = $request->getParameter("v");
  	$this->reviewType = $request->getParameter("t");
  	$this->reviewEntityId = $request->getParameter("e");
  	$this->reviewText = strip_tags( $request->getParameter("review_text") );
  }
  	
  public function executeSend(sfWebRequest $request)
  {
  	if (! $this->getUser()->isAuthenticated()) {
  		echo "error";die;
  	}
  	
  	$review = new SfReview();
  	$review->setValue( $request->getParameter("v") );
  	$review->setText( strip_tags( $request->getParameter("review_text") ) );
  	$review->setSfReviewTypeId( $request->getParameter("t") );
  	$review->setEntityId( $request->getParameter("e") );
  	$review->setSfReviewStatusId( 1 );
  	$review->setSfGuardUserId( $this->getUser()->getGuardUser()->getId() );
  	SfReviewPeer::doInsert($review);
  }
}

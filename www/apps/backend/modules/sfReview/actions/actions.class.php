<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfReviewPlugin/modules/sfReview/lib/BaseSfReviewActions.class.php');

/**
 * sfReview actions.
 *
 * @package    sf_sandbox
 * @subpackage sfReview
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class sfReviewActions extends BaseSfReviewActions
{
	public function executeUpdate(sfWebRequest $request){
		$cacheManager = $this->getContext()->getViewCacheManager();
	  	if ($cacheManager != null) {
	  		$reviewOri = $this->getRoute()->getObject();
		  	if ($reviewOri->getSfReviewType() == null){
		  		$review = $reviewOri->getSfReviewRelatedBySfReviewId();
		  	}
		   	else {
		   		$review = $reviewOri;
		   	}
		   	if ($review->getSfReviewTypeId() == 1){
		   		$politico = PoliticoPeer::retrieveByPK( $review->getEntityId() );
		    	$cacheManager->remove("politico/show?id=".$politico->getVanity()."");
		   	}
	  	}
		parent::executeUpdate( $request );
	}
}

<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasesfReviewFront actions.
 *
 * @package    Voota
 * @subpackage oauth
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class api_demoActions extends sfActions
{	
	const USER_ID = 1;
	
  public function initialize($context, $moduleName, $actionName){
  	parent::initialize($context, $moduleName, $actionName);
  	
    $this->consumerKey = sfConfig::get('app_apidemo_consumer_key');
  	$this->consumerSecret = sfConfig::get('app_apidemo_consumer_secret');
  	$serverUrl = sfConfig::get('app_apidemo_server_url');
  	
  	$this->vootaApi = new VootaApi($serverUrl);
  }
	
  public function executeAuth(sfWebRequest $request){
	$this->vootaApi->authenticate($this->consumerKey, $this->consumerSecret, self::USER_ID, $this->getController()->genUrl('api_demo/callback', true));
  }    

  
  public function executeCallback(sfWebRequest $request){
	$this->vootaApi->finishAuthenticate( $this->consumerKey, self::USER_ID, $request->getParameter('oauth_token') );
  }

  public function executeMostRecentlyVoted(sfWebRequest $request){
	$this->entities = $this->vootaApi->getTopEntities(self::USER_ID, 25, true);	
  }

  public function executePoliticos(sfWebRequest $request){
	$limit = $this->getRequestParameter("limit", 100);
	$page = $this->getRequestParameter("page", 1);
	$sort = $this->getRequestParameter("sort", 'positive');
	
	$this->entities = array();

	$this->entities = $this->vootaApi->getEntities(self::USER_ID, 'politician', $limit, $page, $sort);
	//var_dump($this->entity);
  }
  
  public function executePostReview(sfWebRequest $request){
    if ( $request->isMethod('post') ) {
	  	$entity = $this->getRequestParameter("entity");
	  	$value = $this->getRequestParameter("value");
	  	$text = $this->getRequestParameter("text");
	  	$type = $this->getRequestParameter("type");

		$this->res = $this->vootaApi->postReview(self::USER_ID, $entity, $type, $value, $text);
    }
  }
  
  public function executeReviews(sfWebRequest $request){  	
	$type = $this->getRequestParameter("type");
	$entity = $this->getRequestParameter("entity");
	
	$this->reviews = $this->vootaApi->getReviews(self::USER_ID, $entity, $type);

  }
  
  public function executeSearch(sfWebRequest $request){  	
	$q = $this->getRequestParameter("q");
	
	$this->entities = $this->vootaApi->search(self::USER_ID, $q);
  }

  public function executeProposal(sfWebRequest $request){
	$id = $this->getRequestParameter("id", false);

	$this->entity = $this->vootaApi->getEntity(self::USER_ID, 'proposal', $id);
  }
}

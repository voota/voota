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
	/* Local 
	const CONSUMER_KEY = '4f9ebe0ee2536d34340007a186fa09d204bb9d5be';
  	const CONSUMER_SECRET = 'dd1ed090c1ccc40caa2d1d6d6740ab5d';
	const USER_ID = 105;
	/* 
	/* Test	 */
  	const CONSUMER_KEY = '5126ba4d6c7b9c20d8293c3d522cd60204bb9d344';
  	const CONSUMER_SECRET = '51d72371e20c6adc2c289838ed20e249';
	const USER_ID = 9;
	/* */
	
  public function executeAuth(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$vootaApi->authenticate(self::CONSUMER_KEY, self::CONSUMER_SECRET, self::USER_ID, $this->getController()->genUrl('api_demo/callback', true));
  }    

  
  public function executeCallback(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$vootaApi->finishAuthenticate( self::CONSUMER_KEY, self::USER_ID, $request->getParameter('oauth_token') );
  }

  public function executeMostRecentlyVoted(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$this->entities = $vootaApi->getTopEntities(self::USER_ID, 6);	
  }

  public function executePoliticos(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	$limit = $this->getRequestParameter("limit", 20);
	$page = $this->getRequestParameter("page", 1);
	$sort = $this->getRequestParameter("sort", 'positive');
	
	$this->entities = array();

	$this->entities = $vootaApi->getEntities(self::USER_ID, 'politician', $limit, $page, $sort);
	//var_dump($this->entity);
  }
  
  public function executePostReview(sfWebRequest $request){
    if ( $request->isMethod('post') ) {
	  	$entity = $this->getRequestParameter("entity");
	  	$value = $this->getRequestParameter("value");
	  	$text = $this->getRequestParameter("text");
	  	$type = $this->getRequestParameter("type");
  	
		$vootaApi =  new VootaApi();

		$this->res = $vootaApi->postReview(self::USER_ID, $entity, $type, $value, $text);
    }
  }
  
  public function executeReviews(sfWebRequest $request){  	
	$type = $this->getRequestParameter("type");
	$entity = $this->getRequestParameter("entity");
	
	$vootaApi =  new VootaApi();
	$this->reviews = $vootaApi->getReviews(self::USER_ID, $entity, $type);

  }
  
  public function executeSearch(sfWebRequest $request){  	
	$q = $this->getRequestParameter("q");
	
	$vootaApi =  new VootaApi();
	$this->entities = $vootaApi->search(self::USER_ID, $q);

  }
}

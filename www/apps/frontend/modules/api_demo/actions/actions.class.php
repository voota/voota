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
  	const CONSUMER_KEY = 'dc8bdeeace2bf2e4061de5eca8f8fc4a04b8d80b0';
  	const CONSUMER_SECRET = 'ec2867202655b604ed5b848e7e0c592a';
	const USER_ID = 99;
	
  public function executeAuth(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$vootaApi->authenticate(self::CONSUMER_KEY, self::CONSUMER_SECRET, self::USER_ID, 'http://localhost/frontend_dev.php/api_demo/callback');
  }    

  
  public function executeCallback(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$vootaApi->finishAuthenticate( self::CONSUMER_KEY, self::USER_ID, $request->getParameter('oauth_token') );
  }

  public function executeMostRecentlyVoted(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$this->entities = $vootaApi->getTop(self::USER_ID, 6);	
  }

  public function executePoliticos(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$this->entities = array();

	$this->entities = $vootaApi->getPoliticos(self::USER_ID);
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
}

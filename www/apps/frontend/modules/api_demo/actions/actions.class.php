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
  	const CONSUMER_KEY = '0cfc77021ea312912822378fc686183104b82ac7b';
  	const CONSUMER_SECRET = 'e6f349af273e43cdeb72576fa8e35e81';
	const USER_ID = 1;
	
  public function executeAuth(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$politicos = $vootaApi->authenticate(self::CONSUMER_KEY, self::CONSUMER_SECRET, self::USER_ID, 'http://localhost/frontend_dev.php/api_demo/callback');
  }    

  
  public function executeCallback(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$vootaApi->finishAuthenticate( self::CONSUMER_KEY, self::USER_ID, $request->getParameter('oauth_token') );
  }

  public function executeMostRecentlyVoted(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$this->entities = $vootaApi->getMostRecentlyVoted(1);	
  }

  public function executePoliticos(sfWebRequest $request){
	$vootaApi =  new VootaApi();
	
	$this->entities = $vootaApi->getPoliticos(1);	
  }
}

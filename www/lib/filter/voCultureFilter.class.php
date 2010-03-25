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
class voCultureFilter extends sfGuardBasicSecurityFilter
{
	private static $domains = array('es' => 'es', 'cat' => 'ca'); 
	private static $extensions = array('es' => 'es', 'ca' => 'cat'); 
	
  public function execute ($filterChain)
  {
  	$request = sfContext::getInstance()->getRequest();
  	$culture = $request->getParameter('culture', false);
  	$lang = $request->getParameter('l', false);
  	$user = sfContext::getInstance()->getUser();
  	
  	if ($lang){
  		$this->getContext()->getResponse()->setCookie('voSfCulture', $lang, time()+60*60*24*365, '/');
      	$user->setCulture( $lang );
      	$lastUrl = $user->getAttribute('last_url');
      	
		$lastUrl = preg_replace("/sf_culture=[a-z_]*/is", "sf_culture=$lang", $lastUrl);
      	if ($lastUrl) {
      		$host = @$_SERVER['HTTP_HOST'];
			$host = preg_replace("/(cat|es)$/is", self::$extensions[ $lang ], @$_SERVER['HTTP_HOST']);
			$lastUrl = sfContext::getInstance()->getController()->genUrl($lastUrl);
      		sfContext::getInstance()->getController()->redirect( "http://$host$lastUrl" );
      	}
  	}
  	else {
  		$host = @$_SERVER['HTTP_HOST'];
  		if (preg_match("/\.([a-zA-Z]*)$/", $host, $matches)) {
  			if (in_array($matches[1], array('es', 'cat'))){
  				$culture = self::$domains[ $matches[1] ];
	  			$user->setCulture( $culture );
  			}
  		}
	  	if (!$culture && ($cookie = $request->getCookie('voSfCulture'))){
	  		$user->setCulture( $cookie );
	  	}
  	}
  	    
    $filterChain->execute($filterChain);
  }
}

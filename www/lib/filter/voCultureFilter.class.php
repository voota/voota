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
  public function execute ($filterChain)
  {
  	$request = sfContext::getInstance()->getRequest();
  	$culture = $request->getParameter('culture');
  	$lang = $request->getParameter('l');
  	$user = sfContext::getInstance()->getUser();
  	
  	if ($lang != ''){
  		$this->getContext()->getResponse()->setCookie('voSfCulture', $lang, time()+60*60*24*365, '/');
      	$user->setCulture( $lang );
      	$lastUrl = $user->getAttribute('last_url');
      	
		$lastUrl = preg_replace("/sf_culture=[a-z_]*/is", "sf_culture=$lang", $lastUrl);
      	if ($lastUrl) {
      		sfContext::getInstance()->getController()->redirect( $lastUrl );
      	}
  	}
  	else {
	  	$culture = sfContext::getInstance()->getRequest()->getParameter('sf_culture');
	  	if ($culture == '' && $cookie = $request->getCookie('voSfCulture')){
	  		$user->setCulture( $cookie );
	  	}
  	}
  	    
    $filterChain->execute($filterChain);
  }
}

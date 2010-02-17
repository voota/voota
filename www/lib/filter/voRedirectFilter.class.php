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
class voRedirectFilter extends sfFilter
{
  public function execute ($filterChain)
  {
  	if (!sfContext::getInstance()->getRequest()->isXmlHttpRequest()){  	
	  	$user = sfContext::getInstance()->getUser();
	  	$urlBack = $user->getAttribute('url_back');
	  	if ($urlBack != '') {
	  		if ($user->isAuthenticated()) {
				$user->setAttribute('url_back', '');
	  			sfContext::getInstance()->getController()->redirect( $urlBack );
		  	}
		}
	
		$lastUrl = sfContext::getInstance()->getRouting()->getCurrentInternalUri();
		if (preg_match("/sfGuardAuth\/signin/is", $lastUrl) && !$urlBack){
			$user->setAttribute('url_back', $user->getAttribute('last_url'));
		}
		$user->setAttribute('last_url', $lastUrl);
  	}
	
	
  	// Execute next filter
    $filterChain->execute();  	
  }
}

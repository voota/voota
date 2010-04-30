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
  	$request =  sfContext::getInstance()->getRequest();
  	
  	if (!$request->isXmlHttpRequest()){  
		$lastUrl = sfContext::getInstance()->getRouting()->getCurrentInternalUri();	
	  	$user = sfContext::getInstance()->getUser();
	  	$urlBack = $user->getAttribute('url_back', '', 'vo/redir');
	  	if ($urlBack) {
	  		if ($user->isAuthenticated() && !preg_match("/sfGuardAuth\/signin/is", $urlBack)) {
				$user->setAttribute('url_back', '', 'vo/redir');
	  			sfContext::getInstance()->getController()->redirect( $urlBack );
				die;
		  	}
		}

		// Si forzado por formulario
		$postUrlBack = $request->isMethod('post')?$request->getParameter('url_back', false):false;
		if($postUrlBack && preg_match("/sfGuardAuth\/signin/is", $lastUrl)){
			$user->setAttribute('url_back', $postUrlBack, 'vo/redir');
		}
		elseif (preg_match("/sfGuardAuth\/signin/is", $lastUrl) && (!$urlBack || preg_match("/sfGuardAuth\/signin/is", $urlBack))){
			//echo "GOT".$user->getAttribute('last_url');die;
			$user->setAttribute('url_back', $user->getAttribute('last_url', '', 'vo/redir'), 'vo/redir');
		}
		
		if ($lastUrl && !preg_match("/sfGuardAuth\/signin/is", $lastUrl)){
			$user->setAttribute('last_url', $lastUrl, 'vo/redir');
		}
  	}
	
	
  	// Execute next filter
    $filterChain->execute();  	
  }
}

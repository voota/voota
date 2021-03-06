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
class voBrowserFilter extends sfFilter
{
  public function execute ($filterChain)
  {
  	$request = $this->getContext()->getRequest();
  	$user = $this->getContext()->getUser();
  	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 5') !== FALSE 
  		|| strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6') !== FALSE ) {
		$ie6Warn = $user->getAttribute("ie6");
		if ($ie6Warn !== 'shown'){
			$user->setAttribute("ie6", 'shown');
  			$request->setAttribute("ie6", true);
		}
	}
	
	$culture = $user->getCulture();
	$acceptLangs = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	
	if ( !stristr($acceptLangs, $culture) && (stristr($acceptLangs, 'es') || stristr($acceptLangs, 'ca'))){
		$cultureWarn = $user->getAttribute("cultureWarn");
		if ($cultureWarn !== 'shown'){
			$user->setAttribute("cultureWarn", 'shown');
  			$request->setAttribute("cultureWarn", true);
		}
	}
	
  	// Execute next filter
    $filterChain->execute();  	
  }
}

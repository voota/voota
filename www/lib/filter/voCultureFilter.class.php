<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardBasicSecurityFilter.class.php 9999 2008-06-29 21:24:44Z fabien $
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
  	}
  	if (!$culture != '' && $cookie = $request->getCookie('voSfCulture')){
      	$user->setCulture( $cookie );
  	}
    
    $filterChain->execute($filterChain);
  }
}

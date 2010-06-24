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
class voSecurityFilter extends sfGuardBasicSecurityFilter
{
  public function execute ($filterChain)
  {
    if ($this->isFirstCall() and !$this->getContext()->getUser()->isAuthenticated() && ($cookie = VoFacebook::get_facebook_cookie())){
        $c = new Criteria();
        $c->add(sfGuardUserProfilePeer::FACEBOOK_UID, $cookie['uid']);
        $c->addJoin(sfGuardUserProfilePeer::USER_ID, sfGuardUserPeer::ID);
        if ($user = sfGuardUserPeer::doSelectOne($c)) {
          $this->getContext()->getUser()->signIn($user);
        }
    }
  	/*
    if ($this->isFirstCall() and !$this->getContext()->getUser()->isAuthenticated())
    {
      if ($cookie = $this->getContext()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'sfRemember')))
      {
        $c = new Criteria();
        $c->add(sfGuardRememberKeyPeer::REMEMBER_KEY, $cookie);
        $rk = sfGuardRememberKeyPeer::doSelectOne($c);
        if ($rk && $rk->getSfGuardUser())
        {
          $this->getContext()->getUser()->signIn($rk->getSfGuardUser());
        }
      }
    }
    */
  	/*
    if (
    	$this->getContext()->getUser()->isAuthenticated() 
    	//&& !sfFacebook::getFacebookClient()->get_loggedin_user() 
    	&& !SfVoUtil::isCanonicalVootaUser( $this->getContext()->getUser()->getGuardUser() )
    	) {
    		$this->getContext()->getUser()->signOut();
    }
    */
    
    $filterChain->execute($filterChain);
  }
}

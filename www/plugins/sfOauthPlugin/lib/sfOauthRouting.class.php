<?php

/*
 * This file is part of the symfony package.
 * (c) Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Sergio Viteri <sergio@voota.es>
 * @version    SVN: $Id: sfReviewRouting.class.php 13346 2009-09-09 12:10:17Z Sergio $
 */
class sfOauthRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();

    // preprend our routes
	$r->prependRoute('sf_oauth_register', new sfRoute('/oauth/register', array('module' => 'sfOauthServer', 'action' => 'register')));
	$r->prependRoute('sf_oauth_request_token', new sfRoute('/oauth/request_token', array('module' => 'sfOauthServer', 'action' => 'requestToken')));
	$r->prependRoute('sf_oauth_access_token', new sfRoute('/oauth/access_token', array('module' => 'sfOauthServer', 'action' => 'accessToken')));
	$r->prependRoute('sf_oauth_authorize', new sfRoute('/oauth/authorize', array('module' => 'sfOauthServer', 'action' => 'authorize')));
  }
  
  static public function addRouteForSfOauthRegister(sfEvent $event)
  {
    $event->getSubject()->prependRoute('sf_review_type', new sfPropelRouteCollection(array(
      'name'                 => 'sf_oauth_server',
      'model'                => 'SfOauthServer',
      'module'               => 'sfOauthServer',
      'prefix_path'          => 'sf_oauth_server',
      'with_wildcard_routes' => true,
      'requirements'         => array(),
    )));
  }
  
}

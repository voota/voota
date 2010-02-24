<?php

if (sfConfig::get('app_sf_oauth_plugin_routes_register', true) && in_array('sfOauthServer', sfConfig::get('sf_enabled_modules', array())))
{
  $this->dispatcher->connect('routing.load_configuration', array('sfOauthRouting', 'listenToRoutingLoadConfigurationEvent'));
}

foreach (array('sfOauthRegister', 'sfOauthShow', 'requestToken', 'accessToken', 'authorize') as $module)
{
  if (in_array($module, sfConfig::get('sf_enabled_modules')))
  {
  	$this->dispatcher->connect('routing.load_configuration', array('sfOauthRouting', 'addRouteFor'.str_replace('sfOauth', '', $module)));
  }
}

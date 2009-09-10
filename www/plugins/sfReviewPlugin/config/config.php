<?php

if (sfConfig::get('app_sf_review_plugin_routes_register', true) && in_array('sfReview', sfConfig::get('sf_enabled_modules', array())))
{
  $this->dispatcher->connect('routing.load_configuration', array('sfReviewRouting', 'listenToRoutingLoadConfigurationEvent'));
}

foreach (array('sfReview', 'sfReviewType', 'sfReviewStatus') as $module)
{
  if (in_array($module, sfConfig::get('sf_enabled_modules')))
  {
  	$this->dispatcher->connect('routing.load_configuration', array('sfReviewRouting', 'addRouteForAdmin'.str_replace('sfReview', '', $module)));
  }
}

<?php

# FROZEN_SF_LIB_DIR: /var/www/production/sfweb/www/cache/symfony-for-release/1.2.7/lib

// Autoload swift core
require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/vendor/swiftmailer/swift_required.php';
 
// Autoload symfony core
require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept();
    sfConfig::set('sf_upload_dir', '/var/local/voota/uploads');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfGuardPlugin');
    $this->enablePlugins('sfReviewPlugin');
    $this->enablePlugins('sfOauthPlugin');
    $this->enablePlugins('sfImageTransformPlugin');
  }
}

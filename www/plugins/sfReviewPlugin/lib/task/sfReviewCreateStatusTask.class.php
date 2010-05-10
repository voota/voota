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
class sfReviewCreateStatusTask extends sfPropelBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
    ));

    $this->namespace = 'review';
    $this->name = 'create-status';
    $this->briefDescription = 'Creates basic statuses';

    $this->detailedDescription = <<<EOF
The [review:create-status|INFO] task creates basic statuses:

  [./symfony review:create-status |INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $status = new SfReviewStatus();
    $status->setName('Published');
    $status->setPublished(1);
    $status->setOffensive(0);
    $status->save();
    
    $status = new SfReviewStatus();
    $status->setName('Removed');
    $status->setPublished(0);
    $status->setOffensive(0);
    $status->save();
    
    $status = new SfReviewStatus();
    $status->setName('Offensive');
    $status->setPublished(1);
    $status->setOffensive(1);
    $status->save();
    
    $this->logSection('review', 'Create basic types');
  }
}
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
class sfReviewCreateTypesTask extends sfPropelBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('name', sfCommandArgument::REQUIRED, 'The type name'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
    ));

    $this->namespace = 'review';
    $this->name = 'create-type';
    $this->briefDescription = 'Creates a type';

    $this->detailedDescription = <<<EOF
The [review:create-type|INFO] task creates a type:

  [./symfony review:create-type Celebrity|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $type = new SfReviewType();
    $type->setName($arguments['name']);
    $type->save();

    $this->logSection('review', sprintf('Create user "%s"', $arguments['name']));
  }
}
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
class getFbNamesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'getFbNames';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [getFbNames|INFO] task does things.
Call it with:

  [php symfony getFbNames|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $c = new Criteria();
    $c->addJoin(SfGuardUserPeer::ID, SfGuardUserProfilePeer::USER_ID);
    $c->add(SfGuardUserProfilePeer::FACEBOOK_UID, null, Criteria::ISNOTNULL);
    $c->add(SfGuardUserProfilePeer::NOMBRE, '', Criteria::EQUAL);
    $c->add(SfGuardUserPeer::IS_ACTIVE, 1);
    $profiles = SfGuardUserProfilePeer::doSelect( $c );
    foreach ($profiles as $profile){ 
    	$data = VoFacebook::getData($profile->getFacebookUid());
    	if ($data){
	    	echo $data->name."\n";
	    	$profile->setNombre($data->first_name);
	    	$profile->setApellidos($data->last_name);
	    	$profile->save();
    	}
    }
  }
}

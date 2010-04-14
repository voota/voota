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
class fixVanitiesTask extends sfBaseTask
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
    $this->name             = 'fixVanities';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [updateImages|INFO] task does things.
Call it with:

  [php symfony updateImages|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $c = new Criteria();
    //$c->add(PoliticoPeer::ID, 1, Criteria::EQUAL);
    $politicos = PoliticoPeer::doSelect( $c );
    foreach ($politicos as $politico){
    		
    		$vanity = $politico->getVanity();
    		if ($vanity != SfVoUtil::fixVanityChars($vanity)){
    			echo "politico:$vanity ($politico)\n";
    		}
    		
    }
    $usuarios = SfGuardUserPeer::doSelect( $c );
    foreach ($usuarios as $usuario){
    		
    		$vanity = $usuario->getProfile()->getVanity();
    		if ($vanity != SfVoUtil::fixVanityChars($vanity)){
    			echo "usuario:$vanity ($usuario)\n";
    		}
    }
    $partidos = PartidoPeer::doSelect( $c );
    foreach ($partidos as $partido){
    		
    		$vanity = $partido->getAbreviatura();
    		if ($vanity != SfVoUtil::fixVanityChars($vanity)){
    			echo "partido:$vanity\n";
    		}
    }
  }
}

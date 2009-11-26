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
class genVanityTask extends sfBaseTask
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
      new sfCommandOption('table', null, sfCommandOption::PARAMETER_REQUIRED, 'Tipo de vanities a procesar', 'politico'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'genVanity';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [genVanity|INFO] generates vanity urls for the specified tables (--table option).
Call it with:

  [php symfony genVanity|INFO]
EOF;
  }
  
  protected function execute($arguments = array(), $options = array())
  {
  	if ($options['table'] == 'politico'){
    	$this->politico($arguments, $options);
   	}
   	else if ($options['table'] == 'institucion'){
    	$this->institucion($arguments, $options);
   	}
   	else {
   		echo "No conozco esa tabla (".$options['table'].").\n";
   	}
  }
  
  protected function politico($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $c = new Criteria();
    //$c->add(PoliticoPeer::ID, 1, Criteria::EQUAL);
    $politicos = PoliticoPeer::doSelect( $c );
    foreach ($politicos as $politico){
    	if ($politico->getVanity() == ''){
    		echo "Setting vanity to  " . $politico->getId() ." ...\n";
    		
    		$vanityUrl = SfVoUtil::encodeVanity($politico->getApellidos()) ;
    		
		    $c2 = new Criteria();
		    $c2->add(PoliticoPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    $c2->add(PoliticoPeer::ID, $politico->getId(), Criteria::NOT_EQUAL);
		    $politicosLikeMe = PoliticoPeer::doSelect( $c2 );
		    $counter = 0;
    		foreach ($politicosLikeMe as $politicoLikeMe){
    			$counter++;
    		}
    		$politico->setVanity( "$vanityUrl". ($counter==0?'':"-$counter") );
    		PoliticoPeer::doUpdate( $politico );
    	}
    }
  }

  protected function institucion($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $c = new Criteria();
    $instituciones = InstitucionPeer::doSelect( $c );
    foreach ($instituciones as $institucion){
    	if ($institucion->getVanity() == ''){
    		echo "Setting vanity to  " . $institucion->getId() ." ...\n";
    		
    		$vanityUrl = SfVoUtil::encodeVanity($institucion->getNombreCorto()) ;
    		
		    $c2 = new Criteria();
		    $c2->add(InstitucionPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    $c2->add(InstitucionPeer::ID, $institucion->getId(), Criteria::NOT_EQUAL);
		    $institucionesLikeMe = InstitucionPeer::doSelect( $c2 );
		    $counter = 0;
    		foreach ($institucionesLikeMe as $institucionLikeMe){
    			$counter++;
    		}
    		$institucion->setVanity( "$vanityUrl". ($counter==0?'':"-$counter") );
    		InstitucionPeer::doUpdate( $institucion );
    	}
    }
  }
  
}

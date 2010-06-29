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
class updateImagesTask extends sfBaseTask
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
      new sfCommandOption('table', null, sfCommandOption::PARAMETER_REQUIRED, 'Tipo de imagenes a procesar', 'politico'),
      new sfCommandOption('minid', null, sfCommandOption::PARAMETER_REQUIRED, 'Id de politico a partir del cual procesar', '1'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'updateImages';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [updateImages|INFO] task does things.
Call it with:

  [php symfony updateImages|INFO]
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
   	else if ($options['table'] == 'usuario'){
    	$this->usuario($arguments, $options);
   	}
   	else if ($options['table'] == 'propuesta'){
    	$this->propuesta($arguments, $options);
   	}
   	else if ($options['table'] == 'partido'){
    	$this->partido($arguments, $options);
   	}
   	else {
   		echo "No conozco esa tabla (".$options['table'].").\n";
   	}
  }

  private function partido($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $c = new Criteria();
    $c->add(PartidoPeer::ID, $options['minid'], Criteria::GREATER_EQUAL);
    $partidos = PartidoPeer::doSelect( $c );
    foreach ($partidos as $partido){
    	if ($partido->getImagen() != ''){
    		echo "Creating " . $partido->getImagen() ." ...\n";
    		$s3->createPartidoFromOri( $partido->getImagen() );
    	}
    }
  }
  private function propuesta($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $c = new Criteria();
    $c->add(PropuestaPeer::ID, $options['minid'], Criteria::GREATER_EQUAL);
    $propuestas = PropuestaPeer::doSelect( $c );
    foreach ($propuestas as $propuesta){
    	if ($propuesta->getImagen() != ''){
    		echo "Creating " . $propuesta->getImagen() ." ...\n";
    		$s3->createFromOri( "propuestas", $propuesta->getImagen() );
    	}
    }
  }
  private function politico($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $c = new Criteria();
    $c->add(PoliticoPeer::ID, $options['minid'], Criteria::GREATER_EQUAL);
    $politicos = PoliticoPeer::doSelect( $c );
    foreach ($politicos as $politico){
    	if ($politico->getImagen() != ''){
    		echo "Creating " . $politico->getImagen() ." ...\n";
    		$s3->createPoliticoFromOri( $politico->getImagen() );
    	}
    }
  }
  private function institucion($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $instituciones = InstitucionPeer::doSelect(new Criteria());
    foreach ($instituciones as $institucion){
    	if ($institucion->getImagen() != ''){
    		echo "Creating " . $institucion->getImagen() ." ...\n";
    		$s3->createInstitucionFromOri( $institucion->getImagen() );
    	}
    }
  }
  private function usuario($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $s3 = new S3Voota();
    $c = new Criteria();
    $usuarios = SfGuardUserProfilePeer::doSelect( $c );
    foreach ($usuarios as $usuario){
    	if ($usuario->getImagen() != ''){
    		echo "Creating " . $usuario->getImagen() ." ...\n";
    		$s3->createUsuarioFromOri( $usuario->getImagen() );
    	}
    }
  }
}

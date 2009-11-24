<?php

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
   	else {
   		echo "No conozco esa tabla (".$options['table'].").\n";
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
}

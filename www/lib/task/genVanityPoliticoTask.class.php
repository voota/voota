<?php

class genVanityPoliticoTask extends sfBaseTask
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
    $this->name             = 'genVanityPolitico';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [updateImages|INFO] task does things.
Call it with:

  [php symfony genVanityPolitico|INFO]
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
}

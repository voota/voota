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
      new sfCommandOption('force', null, sfCommandOption::PARAMETER_REQUIRED, 'Generar aunque ya exista', '0'),
      new sfCommandOption('min-id', null, sfCommandOption::PARAMETER_REQUIRED, 'Id a partir del cual regenerar', '0'),
      new sfCommandOption('with-name', null, sfCommandOption::PARAMETER_REQUIRED, 'Id a partir del cual regenerar', '0'),
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
    if( $options['min-id'] != "0" ){
    	$c->add(PoliticoPeer::ID, $options['min-id'], Criteria::GREATER_EQUAL);
    }
    $politicos = PoliticoPeer::doSelect( $c );
    foreach ($politicos as $politico){
    	if ($politico->getVanity() == '' || $options['force'] == '1'){
    		
    		if($options['with-name'] == "1"){
    			$newVanityString = 	$politico->getNombre() . '-' .$politico->getApellidos();
    		}
    		else{
    			$newVanityString = 	$politico->getApellidos();
      		}
    		
    		$vanityUrl = SfVoUtil::encodeVanity( $newVanityString ) ;
    		
		    $c2 = new Criteria();
		    $c2->add(PoliticoPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    $c2->add(PoliticoPeer::ID, $politico->getId(), Criteria::NOT_EQUAL);
		    $politicosLikeMe = PoliticoPeer::doSelect( $c2 );
		    $counter = 0;
    		foreach ($politicosLikeMe as $politicoLikeMe){
    			$aVanity = str_replace("-", "\-", $vanityUrl);
    			
    			if (preg_match(SfVoUtil::voDecode("/^$vanityUrl\-([0-9]*)$/is"), SfVoUtil::voDecode($politicoLikeMe->getVanity()), $matches)) {
    				if ($counter < (1 + $matches[1])){
    					$counter = 1 + $matches[1];	
    				}
    				else {
    					$counter++;
    				}
    			}
    			else {
    				$counter++;
    			}
    		}
    		
    		$newVanity = "$vanityUrl". ($counter==0?'':"-$counter");
    		echo "Setting vanity from ". $politico->getVanity()." to  " . $newVanity ." ...\n";
    		
    		$politico->setVanity( $newVanity );
    		$politico->save();    		
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
    	if ($institucion->getVanity('es') == null || $institucion->getVanity('es') == ''){
    		echo "Setting vanity to  " . $institucion->getId() ." ...\n";
    		
    		$vanityUrl = SfVoUtil::encodeVanity($institucion->getNombreCorto('es')) ;
    		
		    $c2 = new Criteria();
  			$c2->addJoin(InstitucionPeer::ID, InstitucionI18nPeer::ID, Criteria::LEFT_JOIN);
		    $c2->add(InstitucionI18nPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    $c2->add(InstitucionPeer::ID, $institucion->getId(), Criteria::NOT_EQUAL);
		    $institucionesLikeMe = InstitucionPeer::doSelect( $c2 );
		    $counter = 0;
    		foreach ($institucionesLikeMe as $institucionLikeMe){
    			$counter++;
    		}
    		$institucion->setVanity( "$vanityUrl". ($counter==0?'':"-$counter"), 'es' );
    		$institucion->save();
    	}
    }
  }
  
}

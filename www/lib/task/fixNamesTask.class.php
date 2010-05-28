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
class fixNamesTask extends sfBaseTask
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
    $this->name             = 'fixNames';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [fixNames|INFO] task does things.
Call it with:

  [php symfony fixNames|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
    $c = new Criteria();

    #$c->add(PoliticoPeer::ID, 18256, Criteria::EQUAL);
    $politicos = PoliticoPeer::doSelect( $c );
    
    #echo SfVoUtil::myUcfirst("Casilda")."\n";die;
    
    foreach ($politicos as $politico){
    		$vanity = $politico->getVanity();
    		$nombre = $politico->getNombre();
    		$apellidos = $politico->getApellidos();
    
    		if (strcmp($vanity, ($newVanity = SfVoUtil::fixCase($vanity)))){
    			echo "politico:$vanity -> $newVanity\n";
    			$politico->setVanity($newVanity);
    		}
    		if ($nombre != ($newNombre = SfVoUtil::fixCase($nombre))){
    			echo "politico:$nombre -> $newNombre\n";
    			$politico->setNombre($newNombre);
    		}
    		if ($apellidos != ($newApellidos = SfVoUtil::fixCase($apellidos))){
    			echo "politico:$apellidos -> $newApellidos\n";
    			$politico->setApellidos($newApellidos);
    		}
    		$politico->save();
    }

    $instituciones = InstitucionI18nPeer::doSelect( $c );
    foreach ($instituciones as $institucion){
    		
    		$vanity = $institucion->getVanity();
    		$nombreCorto = $institucion->getNombreCorto();
    		$nombre = $institucion->getNombre();
    
    		if (strcmp($vanity, ($newVanity = SfVoUtil::fixCase($vanity)))){
    			echo "institucion:$vanity -> $newVanity\n";
    			$institucion->setVanity($newVanity);
    		}
    		if (strcmp($nombreCorto, ($newNombreCorto = SfVoUtil::fixCase($nombreCorto)))){
    			echo "institucion:$nombreCorto -> $newNombreCorto\n";
    			$institucion->setNombreCorto($newNombreCorto);
    		}
    		if (strcmp($nombre, ($newNombre = SfVoUtil::fixCase($nombre)))){
    			echo "institucion:$nombre -> $newNombre\n";
    			$institucion->setNombre($newNombre);
    		}
    		$institucion->save();
    }

    $geos = GeoPeer::doSelect( $c );
    foreach ($geos as $geo){
    		
    		$nombre = $geo->getNombre();
    
    		if (strcmp($nombre, ($newNombre = SfVoUtil::fixCase($nombre)))){
    			echo "geo:$nombre -> $newNombre\n";
    			$geo->setNombre($newNombre);
    		}
    		$geo->save();
    }
    
  }
}

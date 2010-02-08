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
class fixInstitucionTask extends sfBaseTask
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
    $this->name             = 'fixInstitucion';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [fixInstitucion|INFO] generates vanity urls for the specified tables (--table option).
Call it with:

  [php symfony fixInstitucion|INFO]
EOF;
  }
  
  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $c = new Criteria();
    $instituciones = InstitucionPeer::doSelect( $c );
    foreach ($instituciones as $institucion){
    	if ( preg_match("/Ayuntamiento\-de\-/is", $institucion->getVanity('es')) || preg_match("/Ayuntamiento de /is", $institucion->getNombreCorto()) ){
    		
    		echo "Setting vanity of  " . $institucion->getId() ." ";
    		echo " from  " . $institucion->getVanity('es') ." ";
    		echo " to  " . str_replace("-de-", "-", $institucion->getVanity('es')) .", ";
    		echo " nombre_corto from  " . $institucion->getNombreCorto('es') ." ";
    		echo " to  " . str_replace(" de ", " ", $institucion->getNombreCorto('es')) ." ...\n";
    		
    		$institucion->setVanity( str_replace("Ayuntamiento-de-", "Ayuntamiento-", $institucion->getVanity('es')), 'es' );
    		$institucion->setNombreCorto( str_replace("Ayuntamiento de ", "Ayuntamiento ", $institucion->getNombreCorto('es')), 'es' );
    		$institucion->save();
    		/*
    		$vanityUrl = SfVoUtil::encodeVanity($institucion->getNombreCorto()) ;
    		
		    $c2 = new Criteria();
		    $c2->add(InstitucionPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    $c2->add(InstitucionPeer::ID, $institucion->getId(), Criteria::NOT_EQUAL);
		    $institucionesLikeMe = InstitucionPeer::doSelect( $c2 );
		    $counter = 0;
    		foreach ($institucionesLikeMe as $institucionLikeMe){
    			$counter++;
    		}
    		InstitucionPeer::doUpdate( $institucion );
    		*/
    	}
    	
    	if ($institucion->getVanity('ca') == '' || $institucion->getVanity('ca') == null){
    		echo "creando ca en ". $institucion->getId() ."... \n";
    		$institucion->setVanity( str_replace("Ayuntamiento", "Ajuntament", $institucion->getVanity('es')), 'ca' );
    		$institucion->setNombreCorto( str_replace("Ayuntamiento", "Ajuntament ", $institucion->getNombreCorto('es')), 'ca' );
    		$institucion->setNombre( str_replace("Ayuntamiento", "Ajuntament ", $institucion->getNombre('es')), 'ca' );
    		$institucion->save();
    	}
    }
  }
  
}

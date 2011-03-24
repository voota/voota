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
class createElectionsTask extends sfBaseTask
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
    $this->name             = 'createElections';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [createElections|INFO] task does things.
Call it with:

  [php symfony createElections|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
    $c = new Criteria();
    $c->add(InstitucionI18nPeer::NOMBRE, 'Ayuntamiento%', Criteria::LIKE);
    $c->add(InstitucionI18nPeer::CULTURE, 'es');

    $instituciones = InstitucionI18nPeer::doSelect( $c );
    foreach ($instituciones as $institucion){
	    $geo = GeoPeer::retrieveByPK($institucion->getInstitucion()->getGeoId());
	    if ($geo) {
	    	echo ".";
		    $nombreCorto = $geo->getNombre();
	    	//$nombreCorto = $institucion->getInstitucion()->getGeo()->getNombre();
	    	$vanityUrl = SfVoUtil::encodeVanity( $nombreCorto );
	    				    	
		    $c2 = new Criteria();
		    $c2->add(EleccionPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    //$c2->add(EleccionPeer::ID, $id, Criteria::NOT_EQUAL);
		    $eleccionesLikeMe = EleccionPeer::doSelect( $c2 );
		    $counter = 0;
		    foreach ($eleccionesLikeMe as $eleccionLikeMe){
		    	$counter++;
		    }
		    $vanity = "$vanityUrl". ($counter==0?'':"-$counter");
	    	
	    	$eleccion = new Eleccion();
	    	$eleccion->setVanity($vanity);
	    	$eleccion->save();
	    	
	    	$ei = new EleccionInstitucion();
	    	$ei->setEleccion($eleccion);
	    	$ei->setInstitucion($institucion->getInstitucion());
	    	$ei->save();
	    	
	    	$eleccion_i18n = new EleccionI18n();
	    	$eleccion_i18n->setCulture( 'es' );
	    	$eleccion_i18n->setNombreCorto($nombreCorto);
	    	$eleccion_i18n->setNombre("Elecciones al Ayuntamiento de $nombreCorto");
	    	$eleccion_i18n->setEleccion($eleccion);
	    	$eleccion_i18n->save();
	    	
	    	$eleccion_i18n = new EleccionI18n();
	    	$eleccion_i18n->setCulture( 'ca' );
	    	$eleccion_i18n->setNombreCorto($nombreCorto);
	    	$eleccion_i18n->setNombre("Eleccions al Ajuntament de $nombreCorto");
	    	$eleccion_i18n->setEleccion($eleccion);
	    	$eleccion_i18n->save();
	    	
	    	$convocatoria = new Convocatoria();
	    	$convocatoria->setEleccion($eleccion);
	    	$convocatoria->setNombre('2011');
	    	$convocatoria->setFecha('2011/05/22');
	    	$convocatoria->save();
	    	
	    	$convocatoria_i18n = new ConvocatoriaI18n();
	    	$convocatoria_i18n->setConvocatoria( $convocatoria );
	    	$convocatoria_i18n->setCulture('es');
	    	$convocatoria_i18n->setDescripcion("Las listas y candidatos que se presentan a las elecciones de mayo. Vota y elige al alcalde y a los concejales de $nombreCorto. Compara las listas cerradas de los partidos con las listas abiertas de Voota, la lista oficial contra lo que dice la calle.");
	    	$convocatoria_i18n->save();
	    	
	    	$convocatoria_i18n = new ConvocatoriaI18n();
	    	$convocatoria_i18n->setConvocatoria( $convocatoria );
	    	$convocatoria_i18n->setCulture('ca');
	    	$convocatoria_i18n->setDescripcion("Las listas y candidatos que se presentan a las elecciones de mayo. Vota y elige al alcalde y a los concejales de $nombreCorto. Compara las listas cerradas de los partidos con las listas abiertas de Voota, la lista oficial contra lo que dice la calle.");
	    	$convocatoria_i18n->save();
	    	
	    	$circu = new Circunscripcion();
	    	$circu->setGeo($geo);
	    	$criteria = new Criteria();
	    	$criteria->add(PoliticoInstitucionPeer::INSTITUCION_ID, $institucion->getId());
	    	$count = PoliticoInstitucionPeer::doCount($criteria);
	    	$circu->setEscanyos($count);
	    	$circu->save();
	    	
	    }    		
    }
    
    
  }
}

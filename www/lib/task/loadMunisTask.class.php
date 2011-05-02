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
class loadMunisTask extends sfBaseTask
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
    $this->name             = 'loadMunis';
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
    
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		while($line = fgets($handle)){
			$data = explode(";", "$line");
			
			$c = new Criteria();
			$c->add(GeoPeer::NOMBRE, $data[3]);
			$geos = GeoPeer::doSelect($c);
			$aGeo = false;
			foreach ($geos as $geo){
				if ($geo->getGeoRelatedByGeoId() != null && $geo->getGeoRelatedByGeoId()->getCodigo() && $geo->getGeoRelatedByGeoId()->getCodigo() != ''){
					//echo 'geo: ' . $geo->getNombre() . "\n";
					$aGeo = $geo;
				}
			}
			if (!$aGeo) {
				echo 'Not found: (' . $data[3] . ")\n";
				continue;
			}
			
			$c = new Criteria();
			$c->add(PartidoPeer::ABREVIATURA, $data[5]);
			$partido = PartidoPeer::doSelectOne($c);
			if (!$partido)
				echo "Not found: (". $data[5].")\n";
				
			$c = new Criteria();
			$c->add(CircunscripcionPeer::GEO_ID, $aGeo->getId());
			$circu = CircunscripcionPeer::doSelectOne($c);
			
			$c = new Criteria();
   			$c->addJoin(ConvocatoriaPeer::ELECCION_ID, EleccionPeer::ID);
   			$c->addJoin(EleccionInstitucionPeer::ELECCION_ID, EleccionPeer::ID);
   			$c->addJoin(InstitucionPeer::ID, EleccionInstitucionPeer::INSTITUCION_ID);
   			$c->addJoin(InstitucionPeer::GEO_ID, $aGeo->getId());
   			
			$convocatoria = ConvocatoriaPeer::doSelectOne($c);						
			
			$c = new Criteria();
			$c->add(ListaPeer::CONVOCATORIA_ID, $convocatoria->getId());
			$c->add(ListaPeer::CIRCUNSCRIPCION_ID, $circu->getId());
			$c->add(ListaPeer::PARTIDO_ID, $partido->getId());
			$lista = ListaPeer::doSelectOne($c);
			
			if (!$lista){
				$lista = new Lista();
				$lista->setPartido($partido);
				$lista->setCircunscripcion($circu);
				$lista->setConvocatoria($convocatoria);
				$lista->save();
				echo "Created lista ($partido, $circu)\n";
			}
	    	
	    	
			$politicos = false;
		    $c = new Criteria();
		    
		    $c->add("concat(nombre, ' ', apellidos)", ( trim($data[2]) ) );
		    //$c->add('fullname', utf8_encode( trim($data[2]) ), Criteria::EQUAL);
		    $politicos = PoliticoPeer::doSelect( $c );
		    if (count($politicos) != 0){
		    	echo "(ASIGNADO) ".$data[2] ."\n";
		    	$politico = $politicos[0];
		    }
		    else {
		    	echo "(NUEVO) ".$data[2] . "\n";
		    	$politico = new Politico();
		    	$nombreApellidos = explode(" ", $data[2]);
		    	$nombre = array_shift($nombreApellidos);
		    	$apellidos = implode(" ", $nombreApellidos);
		    	
		    	$politico->setNombre(($nombre));
		    	$politico->setApellidos(($apellidos));
		    	$politico->setPartido($lista->getPartido());
		    	$politico->setSexo($data[1]=="hombre"?'H':'M');
		    	$politico->save();
		    	$politicoI18n = new PoliticoI18n();
		    	$politicoI18n->setPolitico($politico);
		    	$politicoI18n->setCulture('es');
		    	$politicoI18n->save();
		    	$politicoI18n = new PoliticoI18n();
		    	$politicoI18n->setPolitico($politico);
		    	$politicoI18n->setCulture('ca');
		    	$politicoI18n->save();		    	
		    }
		    $c = new Criteria();
		    $c->add(PoliticoListaPeer::LISTA_ID, $lista->getId() );
		    $c->add(PoliticoListaPeer::POLITICO_ID, $politico->getId() );
		    $pl = PoliticoListaPeer::doSelectOne($c);
		    if (!$pl){
		    	$pl = new PoliticoLista();
		    	$pl->setLista($lista);
		    	$pl->setPolitico($politico);
		    }
		    else {
		    	echo "Ya estaba.\n";
		    }
		    $pl->setOrden($data[0]);
		    $pl->save();
		}
		fclose($handle);
  }
}

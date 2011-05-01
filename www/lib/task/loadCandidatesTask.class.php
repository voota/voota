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
class loadCandidatesTask extends sfBaseTask
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
    $this->name             = 'loadCandidates';
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
			
			
	    	$criteria = new Criteria();
	    	$criteria->add(ListaPeer::ID, $data[5]);
	    	$lista = ListaPeer::doSelectOne($criteria);
	    	
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
		    
		    //echo $data[2];
		}
		fclose($handle);
  }
}

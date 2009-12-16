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
class homeActions extends sfActions{
  public function executeIndexWithoutCulture(sfWebRequest $request) {
  	//global $culture;  	
  	
	//$this->readCookie($this->getRequest());
  	//$this->getUser()->setCulture( $culture );
  	
	$this->redirect( "@homepage" );
  	
  }
  
  public function executeRedir(sfWebRequest $request) {
  	$this->redirect( "@homepage" );
  }
  
  public function executeIndex(sfWebRequest $request) {  	
   	$query = "SELECT p.*
  			FROM politico p
			INNER JOIN sf_review r ON r.entity_id = p.id
			WHERE r.value = 1
			AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
			GROUP BY p.nombre, p.apellidos
			LIMIT 6";
  	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);

	$statement->execute();
	$this->politicosMasVotadosUltimamente = $statement->fetchAll(PDO::FETCH_CLASS, 'Politico');
	/*
	foreach($this->politicosMasVotadosUltimamente as $politico){
		echo $politico->getNombre(). " ".$politico->getApellidos()."(".$politico->getPartido().")"."<br>";
	}
	echo "==============================================<br />";
	*/
	
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	$c->setLimit(5);
  	$this->topPoliticos = PoliticoPeer::doSelect($c);
  	/*
	foreach($this->topPoliticos as $politico){
		echo $politico->getNombre(). " ".$politico->getApellidos()."(".$politico->getPartido().")"."<br>";
	}
	*/
  }
}

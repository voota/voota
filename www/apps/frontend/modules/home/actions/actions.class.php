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
	$this->redirect( "@homepage" );
  }
  
  public function executeRedir(sfWebRequest $request) {
  	$this->redirect( "@homepage" );
  }
  
  public function executeIndex(sfWebRequest $request) {
  	$cpos = new Criteria();
  	$cpos->add(SfReviewPeer::VALUE, 1);
  	$cpos->add(SfReviewPeer::IS_ACTIVE, 1);
  	$cneg = new Criteria();
  	$cneg->add(SfReviewPeer::VALUE, -1);
  	$cneg->add(SfReviewPeer::IS_ACTIVE, 1);
  	
  	$cuser = new Criteria();
  	$cuser->add(sfGuardUserPeer::IS_ACTIVE, 1);
  	
  	$cpol = new Criteria();
  	$cpol->addJoin(PoliticoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
  	$cpol->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Politico::NUM_ENTITY);
  	$cpol->add(SfReviewPeer::IS_ACTIVE, TRUE);
  	$cpol->setDistinct();
  	
  	$cpar = new Criteria();
  	$cpar->addJoin(PartidoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
  	$cpar->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Partido::NUM_ENTITY);
  	$cpar->add(SfReviewPeer::IS_ACTIVE, TRUE);
  	$cpar->setDistinct();
  	
  	$this->totalUpReviews = SfReviewPeer::doCount($cpos);
  	$this->totalDownReviews = SfReviewPeer::doCount($cneg);
  	$this->totalUsers = sfGuardUserPeer::doCount($cuser);
  	$this->totalPoliticos = PoliticoPeer::doCount($cpol);
  	$this->totalPartidos = PartidoPeer::doCount($cpar);
  	
   	$query = "SELECT p.*, sum(value = 1) sumut, sum(value = -1) sumdt, count(*) c
  			FROM politico p
			INNER JOIN sf_review r ON r.entity_id = p.id
			WHERE r.is_active = 1
			AND IFNULL(r.modified_at, r.created_at) > (NOW() - INTERVAL 7 DAY)
			AND r.sf_review_type_id = ". Politico::NUM_ENTITY ."
			GROUP BY p.id
			ORDER BY c desc
			LIMIT 6";
			//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->execute();
	$this->politicosMasVotadosUltimamente = $statement->fetchAll(PDO::FETCH_CLASS, 'Politico');
	
	
   	$query = "SELECT p.*, sum(value = 1) sumut, sum(value = -1) sumdt, count(*) c
  			FROM partido p
			INNER JOIN sf_review r ON r.entity_id = p.id
			WHERE r.is_active = 1
			AND IFNULL(r.modified_at, r.created_at) > (NOW() - INTERVAL 7 DAY)
			AND r.sf_review_type_id = ". Partido::NUM_ENTITY ."
			GROUP BY p.id
			ORDER BY c desc
			LIMIT 6";
			//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);
	$statement->execute();
	$this->partidosMasVotadosUltimamente = $statement->fetchAll(PDO::FETCH_CLASS, 'Partido');
		
	
	$exclude = "";
	$this->reviewables = array();
	$partidosUsed = array();
	foreach ($this->politicosMasVotadosUltimamente as $politico) {
		//if (count($this->reviewables) < 6){
			$isPartido = false;
			foreach ($this->partidosMasVotadosUltimamente as $partido) {
				if (! in_array($partido->getId(), $partidosUsed) && $partido->getTotalt() > $politico->getTotalt() && count($this->reviewables) < 6) {
	    			$this->reviewables[] = $partido;
	    			$partidosUsed[] = $partido->getId();
	    			$isPartido = true;
				}
			}
			if(!$isPartido && count($this->reviewables) < 6) {
    			$this->reviewables[] = $politico;
				$exclude .= ($exclude == ''?'':', ').  $politico->getId();
			}
		//}
	}
		
	if (count($this->politicosMasVotadosUltimamente) < 6) {
	   	$query = "SELECT p.*, max(IFNULL(r.modified_at, r.created_at)) max
	  			FROM politico p
				INNER JOIN sf_review r ON r.entity_id = p.id
				WHERE r.is_active = 1 
				AND r.sf_review_type_id = ". Politico::NUM_ENTITY ." ";
		$query .= $exclude == ''?'':" and p.id not in ($exclude) ";
		$query .= "GROUP BY p.id
				ORDER BY max desc
				LIMIT " . (6 - count($this->politicosMasVotadosUltimamente));
				//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)				
	   	$connection = Propel::getConnection();
		$statement = $connection->prepare($query);
		//$statement->bindValue(1, 6 - count($this->politicosMasVotadosUltimamente));
		
		$statement->execute();
		$this->politicosMasVotadosUltimamenteCont = $statement->fetchAll(PDO::FETCH_CLASS, 'Politico');
	}
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
	echo "==============================================<br />";
	*/
  		
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PartidoPeer::SUMD);
  	$c->setLimit(5);
  	$c->add(PartidoPeer::IS_ACTIVE, true);
  	$this->partidosMasVotados = PartidoPeer::doSelect($c);
  	/*
   	$query = "SELECT pa.*, count( * ) c
			FROM partido pa
			INNER JOIN politico p ON p.partido_id = pa.id
			INNER JOIN sf_review r ON r.entity_id = p.id
			WHERE r.is_active =1
			AND r.value =1
			GROUP BY pa.id
			ORDER BY c DESC
			LIMIT 5";
			//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);

	$statement->execute();
	$this->partidosMasVotados = $statement->fetchAll(PDO::FETCH_CLASS, 'Partido');
	*/
	/*
	foreach($this->partidosMasVotados as $partido){
		echo $partido->getNombre(). "<br>";
	}
	echo "==============================================<br />";
	*/	
   	$query = "SELECT i.*, ii.*, count( * ) c
			FROM institucion i
			INNER JOIN institucion_i18n ii on (i.id = ii.id AND ii.culture = ?)
			INNER JOIN politico_institucion pi on pi.institucion_id = i.id
			INNER JOIN politico p ON pi.politico_id = p.id
			INNER JOIN sf_review r ON r.entity_id = p.id
			WHERE r.is_active =1
			AND r.value =1
			GROUP BY i.id
			ORDER BY c DESC
			LIMIT 5";
			//AND IFNULL(r.modified_at, r.created_at) > DATE_SUB(CURDATE(),INTERVAL 7 DAY)
   	$connection = Propel::getConnection();
	$statement = $connection->prepare($query);

	$statement->execute( array($this->getUser()->getCulture()) );
	$this->institucionesMasVotadas = $statement->fetchAll();
	
	/*
	foreach($this->institucionesMasVotadose as $institucion){
		echo $institucion->getNombre(). "<br>";
	}
	echo "==============================================<br />";
	*/
	
  	$this->response->addMeta('Description', sfContext::getInstance()->getI18N()->__('Comparte opiniones sobre políticos y partidos de España. Ranking de los políticos y partidos más votados.'));
	
  }
}

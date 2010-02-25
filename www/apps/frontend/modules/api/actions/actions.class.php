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
class apiActions extends sfActions{
  const PAGE_SIZE = 20;
  
  public function executeApi(sfWebRequest $request){
  	$data = RestUtils::processRequest();
  	$res = "";
  	
	switch($data->getMethod()) {
		case 'get':
			$method = $request->getParameter('method', 'most_recently_voted');
			$res = $this->$method( $data );
			break;
	}
	
	RestUtils::sendResponse(200, json_encode($res), 'application/json');
  }
  
  private function most_recently_voted( $data ){
  	$c = new Criteria();
  	$pager = new sfPropelPager('Politico', self::PAGE_SIZE);
   	$pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    
    $entities = array();
    foreach ($pager->getResults() as $politico){
    	$entities[] = new Entity( $politico ); 	
    }
  	
  	return $entities;
  }
  
  private function entities($data) {
	$type = "entities_". $this->getRequestParameter("type");	
  	
	return $this->$type( $data );
  }

  private function entities_politico($data) {
  	$sort = $this->getRequestParameter("sort", 'positive');	
  	
  	$c = new Criteria();
  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID, Criteria::LEFT_JOIN);
  	$c->add(PoliticoPeer::VANITY, null, Criteria::ISNOTNULL);
  	if($sort == 'negative') {
  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMD);
  	}
  	else {
  		$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
   	}
  	$pager = new sfPropelPager('Politico', self::PAGE_SIZE);
	$c->setDistinct();
	
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    
    $entities = array();
    foreach ($pager->getResults() as $politico){
    	$entities[] = new Entity( $politico ); 	
    }
	
  	return $entities;
  }
  private function entities_partido($data) {
  	$sort = $this->getRequestParameter("sort", 'positive');	
  	
  	$c = new Criteria();
  	if($sort == 'negative') {
  		$c->addDescendingOrderByColumn(PartidoPeer::SUMD);
  	}
  	else {
  		$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
   	}
  	$pager = new sfPropelPager('Partido', self::PAGE_SIZE);
	$c->setDistinct();
	
    $pager->setCriteria($c);
    $pager->setPage($this->getRequestParameter('page', 1));
    $pager->init();
    
    $entities = array();
    foreach ($pager->getResults() as $partido){
    	$entities[] = new Entity( $partido ); 	
    }
	
  	return $entities;
  }
}

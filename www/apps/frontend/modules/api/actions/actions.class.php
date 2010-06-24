<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * api actions.
 *
 * @package    Voota
 * @subpackage API
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BadRequestException extends Exception { }
class NotAuthorizedException extends Exception { }

class apiActions extends sfActions{
  const PAGE_SIZE = 20;
  
  public function executeApi(sfWebRequest $request){
  	$data = RestUtils::processRequest();
  	$res = "";
  	$code = 200;
  	
  	try {
	  	switch($data->getMethod()) {
			case 'get':
				$method = $request->getParameter('method');
				$res = $this->$method( $data );
				break;
			case 'post':
	            //parse_str(file_get_contents('php://input'), $put_vars); 
	            
				$method = "post_" . $request->getParameter('method', 'review');
				$res = $this->$method( $data );
				break;
		}
  	}
  	catch (BadRequestException $e){
  		$res = $e->getMessage();
  		$code = 400;
  	}
  	catch (Exception $e){
  		$res = $e->getMessage();
  		$code = 500;
  	}
	
	RestUtils::sendResponse($code, json_encode($res), 'application/json');
  }

  /* General methods */
  
  private function institutions( $data ){
  	$q = $this->getRequestParameter("q", '');
  	if (!$q)
  		throw new BadRequestException('A search string must be provided.');
  		
  	$page = $this->getRequestParameter("page", '1');
  	$limit = $this->getRequestParameter("limit", self::PAGE_SIZE);
  	$culture = $this->getRequestParameter("culture", 'es');
  	$type = $this->getRequestParameter("type", false);
  	$this->getUser()->setCulture( $culture );
  	
  	$cl = new SphinxClient ();
  	
  	$dbConf = Propel::getConfiguration();
  	$dsn = $dbConf['datasources']['propel']['connection']['dsn'];
  	$sphinxServer = sfConfig::get('sf_sphinx_server');
  	$cl->SetServer ( $sphinxServer, 3312 );
	$this->limit = 1000;
	$cl->SetLimits ( 0, $this->limit, $this->limit );
	$cl->SetArrayResult ( true ); 
	#instituciones
	$this->res = $cl->Query ( $q, "institucion_$culture" );
	$cl->SetFieldWeights(array('vanity' => 5));
	$cl->SetSortMode ( SPH_SORT_RELEVANCE );
	$institutions = array();
	if ( $this->res!==false ) {
		if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
        	$c = new Criteria();
        	$list = array();
        	foreach ($this->res["matches"] as $idx => $match) {
        		$list[] = $match['id'];
        	}
  			$c->add(InstitucionPeer::ID, $list, Criteria::IN);
  			$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
  			
  			//$instituciones = InstitucionPeer::doSelect($c); 					  			
		  	$pager = new sfPropelPager('Institucion', $limit);
		    $pager->setCriteria($c);
		    $pager->setPage($this->getRequestParameter('page', $page));
		    $pager->init();
		    foreach ($pager->getResults() as $aInstitution){
		    	$institution = new Institution();
		    	$institution->setId( $aInstitution->getId() );
		    	$institution->setVanity( $aInstitution->getVanity() );
		    	$institution->setName( $aInstitution->getNombreCorto() );
		    	$institution->setLongName( $aInstitution->getNombre() );
		    	$institutions[] = $institution; 	
		    }	    
        }	
	}
	
	return $institutions;
  }
  
  private function search( $data ){
  	$q = $this->getRequestParameter("q", '');
  	if (!$q)
  		throw new BadRequestException('A search string must be provided.');
  		
  	$page = $this->getRequestParameter("page", '1');
  	$limit = $this->getRequestParameter("limit", self::PAGE_SIZE);
  	$culture = $this->getRequestParameter("culture", 'es');
  	$type = $this->getRequestParameter("type", false);
  	
  	$cl = new SphinxClient ();
  	
  	$dbConf = Propel::getConfiguration();
  	$dsn = $dbConf['datasources']['propel']['connection']['dsn'];
  	$sphinxServer = sfConfig::get('sf_sphinx_server');
  	$cl->SetServer ( $sphinxServer, 3312 );
	$this->limit = 1000;
	$cl->SetLimits ( 0, $this->limit, $this->limit );
	$cl->SetArrayResult ( true );
  	
    $entities = array();
  	$cl->SetArrayResult(true);
  
  	if ($type && $type != 'party' && $type != 'politician' && $type != 'proposal'){
  			throw new BadRequestException('Invalid type.');
   	}
  	if(!$type || $type == 'party'){
		$this->res = $cl->Query ( SfVoUtil::stripAccents( $q ), "partido_$culture" );
		if ( $this->res!==false ) {
			if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
				$c = new Criteria;
	        	$list = array();
	        	foreach ($this->res["matches"] as $idx => $match) {
	        		$list[] = $match['id'];
	        	}
	        	
	        	$c->add(PartidoPeer::ID, $list, Criteria::IN);
	  			//$c->addDescendingOrderByColumn(PartidoPeer::SUMU);  					  			
			  	$pager = new sfPropelPager('Partido', $limit);
			    $pager->setCriteria($c);
			    $pager->setPage($this->getRequestParameter('page', $page));
			    $pager->init();
			    foreach ($pager->getResults() as $partido){
			    	$entities[] = new Entity( $partido ); 	
			    }	    
	        }	
		}
  	}
  	
  	if(!$type || $type == 'politician'){
		$this->res = $cl->Query ( SfVoUtil::stripAccents( $q ), "politico_$culture" );
		if ( $this->res!==false ) {
			if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
				$c = new Criteria;
	        	$list = array();
	        	foreach ($this->res["matches"] as $idx => $match) {
	        		$list[] = $match['id'];
	        	}
	        	
				$c = new Criteria;
	        	$c->add(PoliticoPeer::ID, $list, Criteria::IN);
	  			//$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);  					  			
			  	$pager = new sfPropelPager('Politico', $limit);
			    $pager->setCriteria($c);
			    $pager->setPage($this->getRequestParameter('page', $page));
			    $pager->init();
			    foreach ($pager->getResults() as $politico){
			    	$entities[] = new Entity( $politico ); 	
			    }
			}	
		}
  	}
  	
  	if(!$type || $type == 'proposal'){
		$this->res = $cl->Query ( SfVoUtil::stripAccents( $q ), "propuesta_$culture" );
		if ( $this->res!==false ) {
			if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
				$c = new Criteria;
	        	$list = array();
	        	foreach ($this->res["matches"] as $idx => $match) {
	        		$list[] = $match['id'];
	        	}
	        	
				$c = new Criteria;
	        	$c->add(PropuestaPeer::ID, $list, Criteria::IN);
	  			//$c->addDescendingOrderByColumn(PropuestaPeer::SUMU);  					  			
			  	$pager = new sfPropelPager('Propuesta', $limit);
			    $pager->setCriteria($c);
			    $pager->setPage($this->getRequestParameter('page', $page));
			    $pager->init();
			    foreach ($pager->getResults() as $propuesta){
			    	$entities[] = new Entity( $propuesta ); 	
			    }
			}	
		}
  	}
  		
  	return $entities;
  }
  
  /* Entities methods */
  
  
  private function top( $data ){
  	$limit = $this->getRequestParameter("limit", '6');
  	$includeProposals = $this->getRequestParameter("proposals", false);
  	
  	$exclude = "";
  	return EntityManager::getTopEntities( $limit, $exclude, 'Entity', $includeProposals );
  }
  
  private function entities($data) {
	$type = "entities_". $this->getRequestParameter("type");	
  	
	return $this->$type( $data );
  }
  
  private function entity($data) {
	$type = "entity_". $this->getRequestParameter("type");	
  	
	return $this->$type( $data );
  }
  
  private function entity_politician($data) {
  	$id = $this->getRequestParameter("id");
  	if (!$id)
  		throw new BadRequestException('The entity id must be provided.');
  		
  	$politico = PoliticoPeer::retrieveByPK( $id );
  	$this->forward404Unless( $politico );  	
	
  	return new Entity( $politico );
  }
  
  private function entity_proposal($data) {
  	$id = $this->getRequestParameter("id");
  	if (!$id)
  		throw new BadRequestException('The entity id must be provided.');
  		
  	$proposal = PropuestaPeer::retrieveByPK( $id );
  	$this->forward404Unless( $proposal );  	
	
  	return new Entity( $proposal );
  }
  
  private function entities_politician($data) {
  	$sort = $this->getRequestParameter("sort", 'positive');	
  	$page = $this->getRequestParameter("page", '1');
  	$limit = $this->getRequestParameter("limit", self::PAGE_SIZE);
  	$institution = $this->getRequestParameter("institution", '');
  	$party = $this->getRequestParameter("party", '');
  
  	if ($sort != 'positive' && $sort != 'negative'){
  			throw new BadRequestException('Invalid sort value.');
   	}
   	
   	$pager = EntityManager::getPoliticos($party, $institution, $this->getUser()->getCulture("es"), $page, $sort == 'positive'?"pd":"nd", $limit);
    
   	$entities = array();
    foreach ($pager->getResults() as $politico){
    	$entities[] = new Entity( $politico ); 	
    }
	
  	return $entities;
  }
  
  private function entity_party($data) {
  	$id = $this->getRequestParameter("id");
  	if (!$id)
  		throw new BadRequestException('The entity id must be provided.');
  	$partido = PartidoPeer::retrieveByPK( $id );
  	$this->forward404Unless( $partido );  	
	
  	return new Entity( $partido );
  }
  
  private function entities_party($data) {
  	$sort = $this->getRequestParameter("sort", 'positive');	
  	$page = $this->getRequestParameter("page", '1');
  	$limit = $this->getRequestParameter("limit", self::PAGE_SIZE);
  
  	if ($sort != 'positive' && $sort != 'negative'){
  			throw new BadRequestException('Invalid sort value.');
   	}
   	  	
   	$pager = EntityManager::getPartidos("", $this->getUser()->getCulture("es"), $page, $sort == 'positive'?"pd":"nd", $limit);
    
    $entities = array();
    foreach ($pager->getResults() as $partido){
    	$entities[] = new Entity( $partido ); 	
    }
	
  	return $entities;
  }
  
  private function entities_proposal($data) {
  	$sort = $this->getRequestParameter("sort", 'positive');	
  	$page = $this->getRequestParameter("page", '1');
  	$limit = $this->getRequestParameter("limit", self::PAGE_SIZE);
  
  	if ($sort != 'positive' && $sort != 'negative'){
  			throw new BadRequestException('Invalid sort value.');
   	}
   	  	
   	$pager = EntityManager::getPropuestas($this->getUser()->getCulture("es"), $page, $sort == 'positive'?"pd":"nd", $limit);
    
    $entities = array();
    foreach ($pager->getResults() as $proposal){
    	$entities[] = new Entity( $proposal ); 	
    }
	
  	return $entities;
  }
    
  /* Reviews methods */
  
  private function reviews($data) {
  	$page = $this->getRequestParameter("page", '1');
  	$limit = $this->getRequestParameter("limit", self::PAGE_SIZE);
  	$type = $this->getRequestParameter("type");
  	$entity = $this->getRequestParameter("entity");
  	$value = $this->getRequestParameter("value", NULL);
  	
   	$typeId = -1;
  	switch($type) {
		case 'politician':
			$typeId = Politico::NUM_ENTITY;
			break;
		case 'party':
			$typeId = Partido::NUM_ENTITY;
			break;
		case 'proposal':
			$typeId = Propuesta::NUM_ENTITY;
			break;
		default:
  			throw new BadRequestException('Invalid type.');
  	}  	
  	$sfReviewsPager = SfReviewManager::getReviewsByEntityAndValue(false, $typeId, $entity, $value, $limit, false, $page);
  
    $reviews = array();
    foreach ($sfReviewsPager->getResults() as $sfReview){
    	$reviews[] = new Review( $sfReview ); 	
    }
    
    return $reviews;
  }
  
  private function post_review($data) {
  	try{
  		$userId = oauthSecurityManager::checkAuthorized();
  	}
  	catch(Exception $e){
  		throw new NotAuthorizedException($e->getMessage());
  	}
  	
  	$entityId = $this->getRequestParameter("entity");
  	$value = $this->getRequestParameter("value");
  	$text = $this->getRequestParameter("text", false);
  	$type = $this->getRequestParameter("type");
  	
  	$key = oauthSecurityManager::getConsummerKey();
  		
  	if (!$entityId || !$value || !$type){
  		throw new BadRequestException("Not enough parameters.");
  	}
  	if ($value != -1 && $value != 1){
  		throw new BadRequestException("Invalid data for 'value'.");
  	}
  	
   	$typeId = -1;
  	switch($type) {
		case 'politician':
			$typeId = Politico::NUM_ENTITY;
			$entity = PoliticoPeer::retrieveByPK($entityId);
			break;
		case 'party':
			$typeId = Partido::NUM_ENTITY;
			$entity = PartidoPeer::retrieveByPK($entityId);
			break;
		case 'proposal':
			$typeId = Propuesta::NUM_ENTITY;
			$entity = PropuestaPeer::retrieveByPK($entityId);
			break;
		default:
  			throw new BadRequestException('Invalid type.');
  	} 
  	
  	try {
  		$this->review = SfReviewManager::postReview($userId, $typeId, $entityId, $value, $text, $entity, false, 0, $key);
  	}
  	catch(Exception $e){
  		throw new Exception($e->getMessage());
  	}

  	return "saved.";
  }
}

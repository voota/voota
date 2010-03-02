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
class apiActions extends sfActions{
  const PAGE_SIZE = 20;
  
  public function executeApi(sfWebRequest $request){
  	$data = RestUtils::processRequest();
  	$res = "";
  	$code = 200;
  	
  	try {
	  	switch($data->getMethod()) {
			case 'get':
				$method = $request->getParameter('method', 'top6');
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
	
	RestUtils::sendResponse(200, json_encode($res), 'application/json');
  }

  /* General methods */
    
  private function search( $data ){
  	$q = $this->getRequestParameter("q", '');
  	$culture = "es";
  	
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
	$this->res = $cl->Query ( SfVoUtil::stripAccents( $q ), "politico_$culture" );
	if ( $this->res!==false ) {
		if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
			$c = new Criteria();
        	$list = array();
        	foreach ($this->res["matches"] as $idx => $match) {
        		$list[] = $match['id'];
        	}
			$c = new Criteria;
        	$c->add(PoliticoPeer::ID, $list, Criteria::IN);
  			$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  			$c->setLimit( 20 );
  			
  			$politicos = PoliticoPeer::doSelect($c);
    
		    foreach ($politicos as $politico){
		    	$entities[] = new Entity( $politico ); 	
		    }
		}	
	}
	
  	return $entities;
  }

  /* Entities methods */
  
  private function top6( $data ){
  	return EntityManager::getTopEntities( 6 );
  }
  
  private function entities($data) {
	$type = "entities_". $this->getRequestParameter("type");	
  	
	return $this->$type( $data );
  }
  
  private function entity($data) {
	$type = "entity_". $this->getRequestParameter("type");	
  	
	return $this->$type( $data );
  }

  private function entity_politico($data) {
  	$id = $this->getRequestParameter("id");
  	$politico = PoliticoPeer::retrieveByPK( $id );
  	$this->forward404Unless( $politico );  	
	
  	return new Entity( $politico );
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
  private function entity_partido($data) {
  	$id = $this->getRequestParameter("id");
  	$partido = PartidoPeer::retrieveByPK( $id );
  	$this->forward404Unless( $partido );  	
	
  	return new Entity( $partido );
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
    
  /* Reviews methods */
  
  private function reviews($data) {
  	$page = $this->getRequestParameter("page", '1');
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
		default:
  			throw new BadRequestException('Invalid type.');
  	}  	
  	$sfReviewsPager = SfReviewManager::getReviewsByEntityAndValue(false, $typeId, $entity, $value, self::PAGE_SIZE, false, $page);
  
    $reviews = array();
    foreach ($sfReviewsPager->getResults() as $sfReview){
    	$reviews[] = new Review( $sfReview ); 	
    }
    
    return $reviews;
  }
  
  private function post_review($data) {
  	$userId = oauthSecurityManager::checkAuthorized();
  	
  	$entity = $this->getRequestParameter("entity");
  	$value = $this->getRequestParameter("value");
  	$text = $this->getRequestParameter("text");
  	$type = $this->getRequestParameter("type");
  		
  	if (!$entity || !$value || !$type){
  		throw new BadRequestException("Not enough parameters.");
  	}
  	if ($value != -1 && $value != 1){
  		throw new BadRequestException("Invalid data for 'value'.");
  	}
  	
   	$typeId = -1;
  	switch($type) {
		case 'politician':
			$typeId = Politico::NUM_ENTITY;
			break;
		case 'party':
			$typeId = Partido::NUM_ENTITY;
			break;
		default:
  			throw new BadRequestException('Invalid type.');
  	}  	
  	
  	// Check if already exists
  	$c = new Criteria;
  	$c->add(SfReviewPeer::ENTITY_ID, $entity);
  	$c->add(SfReviewPeer::SF_GUARD_USER_ID, $userId);
  	$c->add(SfReviewPeer::SF_REVIEW_TYPE_ID, $typeId);
  	$review = SfReviewPeer::doSelectOne( $c );
  	if (!$review){
  		$review = new SfReview;
  		$review->setEntityId($entity);
  		$review->setSfReviewTypeId($typeId);
  		$review->setSfGuardUserId($userId);
  	}
  	$review->setValue($value);
  	$review->setText($text);
  	$review->setSfReviewStatusId(1);
  	try {
  		$review->save();
  	}
  	catch (Exception $e){
  		throw new Exception('Error writing review.');
  	}

  	return "saved.";
  }
}

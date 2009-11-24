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
require_once(sfConfig::get('sf_lib_dir').'/sphinxapi.php');

class generalActions extends sfVoActions{
  public function executeRules(sfWebRequest $request) {
  }
  public function executeAbout(sfWebRequest $request) {
  	$c = new Criteria();
  	//1,2,4,5,6,7
  	$c->add(sfGuardUserPeer::ID, 1);
  	$c->addOr(sfGuardUserPeer::ID, 2);
  	$c->addOr(sfGuardUserPeer::ID, 4);
  	$c->addOr(sfGuardUserPeer::ID, 5);
  	$c->addOr(sfGuardUserPeer::ID, 22);
  	$c->addOr(sfGuardUserPeer::ID, 7);
  	$c->addOr(sfGuardUserPeer::ID, 31);
  	$c->addAscendingOrderByColumn(sfGuardUserPeer::ID);
  	
  	$users = sfGuardUserPeer::doSelect($c);
  	$this->users = array();
  	foreach ($users as $user){
  		$this->users[$user->getid()] = $user;	
  	}
  	
  	$this->title = sfContext::getInstance()->getI18N()->__('Sobre Voota - Quiénes somos', array());
  	  	
    $this->response->setTitle( $this->title );
  }
  public function executeSearch(sfWebRequest $request) {
  	
  	$this->q = $request->getParameter("q");
  	
  	$cl = new SphinxClient ();
	$cl->SetServer ( 'localhost', 3312 );
	/*
	$cl->SetConnectTimeout ( 1 );
	$cl->SetWeights ( array ( 100, 1 ) );
	$cl->SetMatchMode ( SPH_MATCH_ALL );
	if ( count($filtervals) )       $cl->SetFilter ( $filter, $filtervals );
	if ( $groupby )                         $cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
	if ( $sortby )                          $cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
	if ( $sortexpr )                        $cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
	if ( $distinct )                        $cl->SetGroupDistinct ( $distinct );
	if ( $limit )                           $cl->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
	$cl->SetRankingMode ( $ranker );
	*/
	//$cl->SetWeights ( array ( 'vanity' => 100, 'alias' => 100, 'nombre' => 100, 'apellidos' => 100, 'bio' => 1, 'presentacion' => 1, 'residencia' => 1, 'formacion' => 1  ) );
	$this->limit = 1000;
	$cl->SetLimits ( 0, $this->limit, $this->limit );
	$cl->SetArrayResult ( true );
	$this->res = $cl->Query ( SfVoUtil::stripAccents( $this->q ), 'politico' );
	if ( $this->res!==false ) {
		//echo "<pre>";var_dump($this->res);echo "</pre>";
		if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
        	$c = new Criteria();
        	$list = array();
        	foreach ($this->res["matches"] as $idx => $match) {
        		$list[] = $match['id'];
        	}
  			$c->add(PoliticoPeer::ID, $list, Criteria::IN);
  			$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
    		$this->politicosPager = new sfPropelPager('Politico', 10);
		    $this->politicosPager->setCriteria($c);
		    $this->politicosPager->setPage($this->getRequestParameter('page', 1));
		    $this->politicosPager->init();
		    
		    if ($this->politicosPager->getNbResults() == 1){
		    	$res = $this->politicosPager->getResults();
				$this->redirect( "@politico_".$this->getUser()->getCulture( 'es' )."?id=".$res[0]->getVanity() );
		    }
        }	
	}
  }
}

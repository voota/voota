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

class generalActions extends sfActions{
  public function executeRules(sfWebRequest $request) {
  }
  public function executeContact(sfWebRequest $request) {
    $this->form = new ContactForm();
    if ( $request->isMethod('post') ) {
      $this->form->bind($request->getParameter('contact'));
      
      if ($this->form->isValid()) {
      	try {
			$mailBody = $this->getPartial('contactMailBody', array(
			  	'nombre' => $this->form->getValue('nombre'),
			  	'mensaje' => $this->form->getValue('mensaje'),
			  	'email' => $this->form->getValue('email')
			));
			  
			VoMail::sendWithRet("Contacto web [".$this->form->getValue('tipo')."]", $mailBody, 'info-es@voota.es', array('no-reply@voota.es' => 'no-reply Voota'), $this->form->getValue('email'), true);
	      	
			return "SendSuccess";
      	}
      	catch (Exception $e){
      		return "SendFail";      		
      	}
      	/*
	    $c = new Criteria();
	    $c->add(sfGuardUserPeer::USERNAME, $this->form->getValue('username'));
	
	    $user = sfGuardUserPeer::doSelectOne($c);
      	if ($user){
      		$this->sendReminder( $user );
      		return "SentSuccess";
      	}
      	else {
      		return "SentFail";
      	}
      	*/
      }
    }
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
  	$c->addOr(sfGuardUserPeer::ID, 180);
  	$c->addAscendingOrderByColumn(sfGuardUserPeer::ID);
  	
  	$users = sfGuardUserPeer::doSelect($c);
  	$this->users = array();
  	foreach ($users as $user){
  		$this->users[$user->getid()] = $user;	
  	}
  	
  	$this->title = sfContext::getInstance()->getI18N()->__('Sobre Voota - Quiénes somos', array());
  	  	
    $this->response->setTitle( $this->title );
  }
  
  private function resetSphinxClient() {
  	$cl = new SphinxClient ();
  	
  	$dbConf = Propel::getConfiguration();
  	$dsn = $dbConf['datasources']['propel']['connection']['dsn'];
  	$sphinxServer = sfConfig::get('sf_sphinx_server');
  	$cl->SetServer ( $sphinxServer, 3312 );
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
	
	return $cl;
  }
  
  public function executeSearch(sfWebRequest $request) {
   	$this->q = $request->getParameter("q");
  	
   	$cl = $this->resetSphinxClient();
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
				//$this->redirect( "politico/show?id=".$res[0]->getVanity() );
		    }
        }	
	}
	
	$this->res = $cl->Query ( SfVoUtil::stripAccents( $this->q ), 'partido' );
	if ( $this->res!==false ) {
		if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
        	$c = new Criteria();
        	$list = array();
        	foreach ($this->res["matches"] as $idx => $match) {
        		$list[] = $match['id'];
        	}
  			$c->add(PartidoPeer::ID, $list, Criteria::IN);
  			$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
    		$this->partidosPager = new sfPropelPager('Partido', 10);
		    $this->partidosPager->setCriteria($c);
		    $this->partidosPager->setPage($this->getRequestParameter('page', 1));
		    $this->partidosPager->init();
		    
		    if ($this->partidosPager->getNbResults() == 1){
		    	$res = $this->partidosPager->getResults();
				//$this->redirect( "partido/show?id=".$res[0]->getAbreviatura() );
		    }
        }	
	}
	
	$this->res = $cl->Query ( SfVoUtil::stripAccents( $this->q ), 'institucion' );
	if ( $this->res!==false ) {
		if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
        	$c = new Criteria();
        	$list = array();
        	foreach ($this->res["matches"] as $idx => $match) {
        		$list[] = $match['id'];
        	}
  			$c->add(InstitucionPeer::ID, $list, Criteria::IN);
  			$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
    		$this->institucionesPager = new sfPropelPager('Institucion', 10);
		    $this->institucionesPager->setCriteria($c);
		    $this->institucionesPager->setPage($this->getRequestParameter('page', 1));
		    $this->institucionesPager->init();
		    
		    if ($this->institucionesPager->getNbResults() == 1){
		    	$res = $this->institucionesPager->getResults();
				//$this->redirect( "politico/ranking?partido=ALL&institucion=".$res[0]->getNombreCorto() );
		    }
        }	
	}
	$this->results = (isset($this->institucionesPager)?$this->institucionesPager->getNbResults():0) 
		+ ($this->partidosPager?$this->partidosPager->getNbResults():0)
		+ (isset($this->politicosPager)?$this->politicosPager->getNbResults():0);
  }
  
    private function sendMessage( $nombre, $email, $mensaje, $tipo ){
	  
  }
  
}

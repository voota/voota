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
  public function executeTagList(sfWebRequest $request) {
   	$id = $request->getParameter("entityId", false);
   	$type = $request->getParameter("type", false);
   	$this->page = $request->getParameter("page", 1);
   	
  	switch($type){
  		case Politico::NUM_ENTITY:
  			$this->entity = PoliticoPeer::retrieveByPK( $id );
  			break;
  		case Partido::NUM_ENTITY:
  			$this->entity = PartidoPeer::retrieveByPK( $id );
  			break;
   		case Propuesta::NUM_ENTITY:
  			$this->entity = PropuestaPeer::retrieveByPK( $id );
	  		break;
  	}
  }
  public function executeRules(sfWebRequest $request) {
  }
  public function executeContact(sfWebRequest $request) {
   	$t = $request->getParameter("t", '');
   	$e = $request->getParameter("e", '');
   	
  	$this->form = new ContactForm();
  	if ($t){
  		$this->form->setDefaultMsg( "$e: $t" );
  	}
    if ( $request->isMethod('post') && !$t) {
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
	$cl->SetMatchMode ( SPH_SORT_EXTENDED );
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
  	$culture = $this->getUser()->getCulture();
  	
   	$tag = $request->getParameter("tag", false);
   	if ($tag){
	   	$this->q = "#$tag";
   	}
   	else {
	   	$this->q = $request->getParameter("q");
   	}
   	$request->setAttribute("q", $this->q);
  	
   	$resultsArray = array();
   	
   	$cl = $this->resetSphinxClient();   	
   	
   	$needle = SfVoUtil::stripAccents( $this->q );
   	
	$this->ext = "";   		
   	if (strlen($needle) > 0 && strpos($needle, '#') === 0){
		$this->ext = "_tag";   		
		$needle = substr($needle, 1);
   	}
   	
   	if ($needle){
	   	# Partidos
		$cl->SetArrayResult(true);
	   	$this->partidoCounts = false;
		if ($this->ext == "_tag"){
			$cl->SetMatchMode ( SPH_MATCH_PHRASE );
			$cl->SetSortMode ( SPH_SORT_EXTENDED, "cnt DESC" );
			$this->partidoCounts = array();
		}
		else {
			$cl->SetFieldWeights(array('abreviatura' => 5, 'nombre' => 5));
			$cl->SetSortMode ( SPH_SORT_EXPR, "@weight + ( 50 * votes/max_votes )" );
		}
		$this->res = $cl->Query ( $needle, "partido".$this->ext."_$culture" );
		if ( $this->res!==false ) {
			if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
	        	$c = new Criteria();
				$c->addJoin(
					array(PartidoPeer::ID, PartidoI18nPeer::CULTURE),
					array(PartidoI18nPeer::ID, "'$culture'")
				);
	        	$list = array();
	        	$listString = "";
	        	foreach ($this->res["matches"] as $idx => $match) {
						if ($this->ext == "_tag"){
			        		$this->partidoCounts[$match['attrs']['partido_id']] = $match['attrs']['cnt'];
						}
						$id = $this->ext == "_tag"?$match['attrs']['partido_id']:$match['id'];
		        		$list[] = $id;
		        		$listString .= ($listString?',':'')."". $id ."";
	        	}
	  			$c->add(PartidoPeer::ID, $list, Criteria::IN);
	  			//$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
	  			//$c->addDescendingOrderByColumn("(sumu + sumd)");
	  			$c->addAscendingOrderByColumn("FIELD(".PartidoPeer::ID.",$listString) ");
	  			
	  			$partidos = PartidoPeer::doSelect($c);
	  			
	  			$resultsArray = array_merge  ( $resultsArray, $partidos );		    
	        }	
		}
		
		if(!$this->ext){
			$cl = $this->resetSphinxClient();   
			#instituciones
			$this->res = $cl->Query ( $needle, "institucion_$culture" );
			$cl->SetFieldWeights(array('vanity' => 5));
			$cl->SetSortMode ( SPH_SORT_RELEVANCE );
			if ( $this->res!==false ) {
				if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
		        	$c = new Criteria();
		        	$list = array();
		        	foreach ($this->res["matches"] as $idx => $match) {
		        		$list[] = $match['id'];
		        	}
		  			$c->add(InstitucionPeer::ID, $list, Criteria::IN);
		  			$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
		  			
		  			$instituciones = InstitucionPeer::doSelect($c);
		  			
		  			$resultsArray = array_merge  ( $resultsArray, $instituciones );	
		        }	
			}
		}
		
		$cl = $this->resetSphinxClient();   
		# Politicos
		$cl->SetArrayResult(true);
	   	$this->politicoCounts = false;
		if ($this->ext == "_tag"){
			$cl->SetMatchMode ( SPH_MATCH_PHRASE );
			$cl->SetSortMode ( SPH_SORT_EXTENDED, "cnt DESC" );
			$this->politicoCounts = array();
		}
		else {
			$cl->SetFieldWeights(array('nombre' => 5, 'apellidos' => 5));
			$cl->SetSortMode ( SPH_SORT_EXPR, "@weight + ( 50 * votes/max_votes )" );
		}
		
		$this->res = $cl->Query ( $needle, "politico".$this->ext."_es" );
		if ( $this->res !== false ) {
			if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
				$c = new Criteria();
				$c->addJoin(
					array(PoliticoPeer::ID, PoliticoI18nPeer::CULTURE),
					array(PoliticoI18nPeer::ID, "'$culture'")
					, Criteria::LEFT_JOIN
				);
				
	        	$list = array();
	        	$listString = "";
	        	foreach ($this->res["matches"] as $idx => $match) {
					if ($this->ext == "_tag"){
		        		$this->politicoCounts[$match['attrs']['politico_id']] = $match['attrs']['cnt'];
					}
					$id = $this->ext == "_tag"?$match['attrs']['politico_id']:$match['id'];
	        		$list[] = $id;
	        		$listString .= ($listString?',':'')."". $id ."";
	        	}
	  			$c->add(PoliticoPeer::ID, $list, Criteria::IN);
	  			
	  			//$c->addDescendingOrderByColumn("(sumu + sumd)");
	  			$c->addAscendingOrderByColumn("FIELD(".PoliticoPeer::ID.",$listString) ");
	  			
	  			$c->setLimit( 100 );
	  			
	  			$politicos = PoliticoPeer::doSelect($c);
	  			
	  			$resultsArray = array_merge  ( $resultsArray, $politicos );
	        }	
		}
			
		$cl = $this->resetSphinxClient();   
	   	# Propuestas 
		$this->res = $cl->Query ( $needle, "propuesta". $this->ext ."_$culture" );
	   	$this->propuestaCounts = false;
		if ($this->ext == "_tag"){
			$cl->SetMatchMode ( SPH_MATCH_PHRASE );
			$cl->SetSortMode ( SPH_SORT_EXTENDED, "cnt DESC" );
			$this->propuestaCounts = array();
		}
		else {			
			$cl->SetMatchMode ( SPH_MATCH_ALL );
			$cl->SetFieldWeights(array('titulo' => 5));
			$cl->SetSortMode ( SPH_SORT_EXPR, "@weight + ( 50 * votes/max_votes )" );
		}
		if ( $this->res!==false ) {
			if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
	        	$c = new Criteria();
	        	$list = array();
	        	$listString = "";
	        	foreach ($this->res["matches"] as $idx => $match) {
					if ($this->ext == "_tag"){
		        		$this->propuestaCounts[$match['attrs']['propuesta_id']] = $match['attrs']['cnt'];
					}
	        		$id = $this->ext == "_tag"?$match['attrs']['propuesta_id']:$match['id'];
	        		$list[] = $id;
	        		$listString .= ($listString?',':'')."". $id ."";
	        	}
	  			$c->add(PropuestaPeer::ID, $list, Criteria::IN);
	  			//$c->addDescendingOrderByColumn("(sumu + sumd)");
	  			$c->addAscendingOrderByColumn("FIELD(".PropuestaPeer::ID.",$listString) ");
	  			
	  			$propuestas = PropuestaPeer::doSelect($c);
	  			$resultsArray = array_merge  ( $resultsArray, $propuestas );		    
	        }	
		}
		
		if(!$this->ext){
			$cl = $this->resetSphinxClient();   
			// Usuarios
			$this->res = $cl->Query ( $needle, "usuario" );
			$cl->SetFieldWeights(array('nombre' => 5, 'apellidos' => 5));
			$cl->SetSortMode ( SPH_SORT_RELEVANCE );
			$cl->SetMatchMode ( SPH_MATCH_ALL );
			if ( $this->res!==false ) {
				if ( isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
					$c = new Criteria();
					$c->addJoin(sfGuardUserPeer::ID, SfReviewPeer::SF_GUARD_USER_ID, Criteria::LEFT_JOIN);
					
					$rCriterion = $c->getNewCriterion(SfReviewPeer::IS_ACTIVE, true);
					$rCriterion->addOr($c->getNewCriterion(SfReviewPeer::IS_ACTIVE, null, Criteria::ISNULL));
					$c->add( $rCriterion );
					
					$c->addAsColumn('numReviews', 'COUNT('.sfGuardUserPeer::ID.')');
					$c->addSelectColumn('sf_guard_user.*');
					
					$c->addDescendingOrderByColumn('numReviews');
					$c->addGroupByColumn(sfGuardUserPeer::ID);
					
					$c->setDistinct();
		        	$list = array();
		        	foreach ($this->res["matches"] as $idx => $match) {
		        		$list[] = $match['id'];
		        	}
		  			$c->add(sfGuardUserPeer::ID, $list, Criteria::IN);
		  			$c->setLimit( 100 );
		  			
		  			$usuariosRS = sfGuardUserPeer::doSelectStmt($c);
		  			$usuarios = array();
		  			foreach($usuariosRS as $usuarioRS) {
					  $usuario = new SfGuardUser($usuarioRS);
					  $usuario->hydrate($usuarioRS);
					  $usuarios[] = $usuario;
					}
		  			
		  			
		  			$resultsArray = array_merge  ( $resultsArray, $usuarios );
		        }	
			}
		}
   	}
   	
	/*
	$this->results = (isset($this->institucionesPager)?$this->institucionesPager->getNbResults():0) 
		+ ($this->partidosPager?$this->partidosPager->getNbResults():0)
		+ (isset($this->politicosPager)?$this->politicosPager->getNbResults():0);
		*/
	
      $this->results = new myTabPager($resultsArray, 15);
      $this->results->setPage($this->getRequestParameter('page', 1));
      $this->results->init();
      
      
  	$this->title = sfContext::getInstance()->getI18N()->__('"%1%" en Voota', array('%1%' => $this->q));
  	$descStr = "";
  	foreach($resultsArray as $idx => $result){
  		if ($idx < 3){
  			$descStr .= ($descStr?', ':'').$result; 
  		}
  	}
  	$this->response->addMeta('Description', sfContext::getInstance()->getI18N()->__('Resultados de la búsqueda "%1%" en Voota: %2%, ...', array('%1%' => $this->q, '%2%' => $descStr)));
  	  	
    $this->response->setTitle( $this->title );
  }
  
    private function sendMessage( $nombre, $email, $mensaje, $tipo ){
	  
  }

    
  public function executeTags(sfWebRequest $request)
  {
  	$term = $request->getParameter('term');
  	
	  	$c = new Criteria();
	  	$c->add(EtiquetaPeer::TEXTO, "%$term%", Criteria::LIKE);
	  	$etiquetas = EtiquetaPeer::doSelect( $c );
	  	
	  	$res = '[';	
		$idx = 0;
		foreach ($etiquetas as $etiqueta){
			$idx++;
			$res .= ($idx > 1?',':'').'{"id": "'. $etiqueta->getId() .'", "value": "'. $etiqueta .'"}';
		}
		$res .= ']';
		
		$response = $this->getResponse();
	    $response->setContentType('application/json');
	    
		echo $res;die;
  }
  
  public function executeNewtag(sfWebRequest $request)
  {
  	$texto = $request->getParameter('texto', false);
  	$id = $request->getParameter('entity', false);
  	$type = $request->getParameter('type', false);
  	switch($type){
  		case Politico::NUM_ENTITY:
  			$this->entity = PoliticoPeer::retrieveByPK( $id );
  			break;
  		case Partido::NUM_ENTITY:
  			$this->entity = PartidoPeer::retrieveByPK( $id );
  			break;
   		case Propuesta::NUM_ENTITY:
  			$this->entity = PropuestaPeer::retrieveByPK( $id );
	  		break;
  	}

  	if ($this->entity)
  		TagManager::newTag($this->entity, $texto);  	
  }
  
  public function executeRmtag(sfWebRequest $request)
  {
  	$e = $request->getParameter('e', false);
  	$id = $request->getParameter('id', false);
  	$type = $request->getParameter('type', false);
  	TagManager::removeTag($id);  	
  
  	switch($type){
  		case Politico::NUM_ENTITY:
  			$this->entity = PoliticoPeer::retrieveByPK( $e );
  			break;
  		case Partido::NUM_ENTITY:
  			$this->entity = PartidoPeer::retrieveByPK( $e );
  			break;
   		case Propuesta::NUM_ENTITY:
  			$this->entity = PropuestaPeer::retrieveByPK( $e );
	  		break;
  	}
  }
  
}

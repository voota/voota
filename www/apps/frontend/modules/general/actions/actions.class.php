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
  	$c->addOr(sfGuardUserPeer::ID, 9);
  	$c->addOr(sfGuardUserPeer::ID, 738);
  	$c->addOr(sfGuardUserPeer::ID, 27);
  	$c->addOr(sfGuardUserPeer::ID, 447);
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
	$cl->SetConnectTimeout ( 1 );
	
	$this->limit = 15;
	$cl->SetArrayResult ( true );
	
	return $cl;
  }
  
  public function executeSearch(sfWebRequest $request) {
  	$culture = $this->getUser()->getCulture();
   	$this->page = $this->getRequestParameter('page', 1);
  	
   	$tag = $request->getParameter("tag", false);
   	
	$tag = str_replace("_2E_", ".", $tag);
   	if ($tag){
	   	$this->q = "#$tag";
   	}
   	else {
	   	$this->q = $request->getParameter("q");
   	}
   	$request->setAttribute("q", $this->q);
  	
   	$resultsArray = array();
   	
   	$cl = $this->resetSphinxClient();
   	
   	$needle = $this->q;   	
	$this->ext = "";   		
   	if (strlen($needle) > 0 && strpos($needle, '#') === 0){
		$this->ext = "_tag";   		
		$needle = substr($needle, 1);
   	}
   	else {
   		$needle = SfVoUtil::stripAccents( $this->q );
   	}
   	
	$this->politicoCounts = false;
	$this->partidoCounts = false;
	$this->propuestaCounts = false;
   	
   	if ($needle){
		if ($this->ext == "_tag"){
			$cl->SetMatchMode ( SPH_MATCH_PHRASE );
			$cl->SetSortMode ( SPH_SORT_EXTENDED, "cnt DESC" );
			$this->politicoCounts = array();
			$this->partidoCounts = array();
			$this->propuestaCounts = array();
			$indexes = "partido_tag_$culture, politico_tag_$culture, propuesta_tag_$culture";
			$this->res = $cl->Query ( $needle, $indexes );
			if ( $this->res!==false ){
				$this->total = $this->res['total']; 
				$this->totalFound = $this->res['total_found']; 
				$cl->SetLimits ( ($this->page-1) * $this->limit, $this->limit );
				$this->res = $cl->Query ( $needle, $indexes );
			}
		}
		else {
			$cl->SetFieldWeights(array('abreviatura_partido' => 5, 'nombre' => 5, 'apellidos' => 5, 'alias' => 5, 'titulo' => 5, 'nombre_insti' => 8));
			$cl->SetSortMode ( SPH_SORT_EXPR, "@weight + ( 1 * votes/max_votes )" );
			$indexes = "politico_$culture, partido_$culture,propuesta_$culture, institucion_$culture, usuario";
			$this->res = $cl->Query ( $needle, $indexes );
			if ( $this->res!==false ){
				$this->total = $this->res['total']; 
				$this->totalFound = $this->res['total_found']; 
				$cl->SetLimits ( ($this->page-1) * $this->limit, $this->limit );
				$this->res = $cl->Query ( $needle, $indexes );
			}
		}
		if ( $this->res!==false && isset($this->res["matches"]) && is_array($this->res["matches"]) ) {
			foreach ($this->res["matches"] as $match){				
				//echo "<pre>";print_r( $match );echo "</pre>";
				switch ($match['attrs']['type']){
					case 1:
						if ($this->ext == "_tag"){
			        		$this->politicoCounts[$match['attrs']['politico_id']] = $match['attrs']['cnt'];
							$resultsArray[] = PoliticoPeer::retrieveByPK($match['attrs']['politico_id']);
						}
						else {
							$resultsArray[] = PoliticoPeer::retrieveByPK($match['id']);
						}
						break;
					case 2:
						if ($this->ext == "_tag"){
			        		$this->partidoCounts[$match['attrs']['partido_id']] = $match['attrs']['cnt'];
							$resultsArray[] = PartidoPeer::retrieveByPK($match['attrs']['partido_id']);
						}
						else {
							$resultsArray[] = PartidoPeer::retrieveByPK($match['id']);							
						}
						break;
					case 3:
						if ($this->ext == "_tag"){
			        		$this->propuestaCounts[$match['attrs']['propuesta_id']] = $match['attrs']['cnt'];
							$resultsArray[] = PropuestaPeer::retrieveByPK($match['attrs']['propuesta_id']);
						}
						else {
							$resultsArray[] = PropuestaPeer::retrieveByPK($match['id']);
						}
						break;
					case 101:
						$resultsArray[] = InstitucionPeer::retrieveByPK($match['id']);
						break;
					case 102:
						$resultsArray[] = SfGuardUserPeer::retrieveByPK($match['id']);
						break;
				}
			}	
		}
   	}
		
    $this->results = $resultsArray;
      
      
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
  	if ($texto)
  		$texto = trim($texto);
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
  	TagManager::removeTag($id, $e, $type);  	
  
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

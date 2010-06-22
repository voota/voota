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
define("ALL_URL_STRING", 'all');
define("ALL_FORM_VALUE", '0');

class politicoActions extends sfActions
{

  public function executeAcPartido(sfWebRequest $request){
  	$culture = $this->getUser()->getCulture();
  	
  	$term = $request->getParameter('term');
  	$c = new Criteria();
	$c->setLimit( 20 );
	$c->addJoin(
		array(PartidoPeer::ID, PartidoI18nPeer::CULTURE),
		array(PartidoI18nPeer::ID, "'$culture'")
		, Criteria::INNER_JOIN
	);
  	$rCriterion = $c->getNewCriterion(PartidoPeer::ABREVIATURA, "%$term%", Criteria::LIKE);
	$rCriterion->addOr($c->getNewCriterion(PartidoI18nPeer::NOMBRE, "%$term%", Criteria::LIKE));
	$c->add( $rCriterion );
	$partidos = PartidoPeer::doSelect( $c );

	$res = '[';	
	$idx = 0;
	foreach ($partidos as $partido){
		$idx++;
		$res .= ($idx > 1?',':'').'{"id": "'. $partido->getAbreviatura() .'", "value": "'. $partido->getAbreviatura(). ', ' .$partido->getNombre() .'"}';
	}
	$res .= ']';
	
	$response = $this->getResponse();
    $response->setContentType('application/json');
    
	echo $res;die;
  }

  public function executeAcInstitucion(sfWebRequest $request){
  	$culture = $this->getUser()->getCulture();
  	
  	$term = $request->getParameter('term');
  	$c = new Criteria();
	$c->setLimit( 20 );
	$c->addJoin(
		array(InstitucionPeer::ID, InstitucionI18nPeer::CULTURE),
		array(InstitucionI18nPeer::ID, "'$culture'")
		, Criteria::INNER_JOIN
	);
  	$rCriterion = $c->getNewCriterion(InstitucionI18nPeer::NOMBRE_CORTO, "%$term%", Criteria::LIKE);
	$rCriterion->addOr($c->getNewCriterion(InstitucionI18nPeer::NOMBRE, "%$term%", Criteria::LIKE));
	$c->add( $rCriterion );
	$instituciones = InstitucionPeer::doSelect( $c );

	$res = '[';	
	$idx = 0;
	foreach ($instituciones as $institucion){
		$idx++;
		$res .= ($idx > 1?',':'').'{"id": "'. $institucion->getVanity() .'", "value": "'. $institucion->getNombre() .'"}';
	}
	$res .= ']';
	
	$response = $this->getResponse();
    $response->setContentType('application/json');
	
	echo $res;die;
  }
  
  public function executeTake(sfWebRequest $request)
  {
  	$id = $request->getParameter('id');
  	$this->politico = PoliticoPeer::retrieveByPK( $id );
  	
  	if (!$this->getUser()->isAuthenticated()){
  		$url = 'politico/take?id='. $id;
  		$this->getUser()->setAttribute('url_back', $url, 'vo/redir');
  	}
  		
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  	
  	$id = $request->getParameter('id');
  	$this->politico = PoliticoPeer::retrieveByPK( $id );
  	
  	if ($this->politico){
	  	$op = $request->getParameter("op", "a");
	  	if ($op == "c"){
	  		$this->politico->setSfGuardUserId($this->getUser()->getGuardUser()->getId());
	  		$this->politico->setModifiedAt(new DateTime());
	  		$this->politico->save();
	  		
	  		// Send mail to politician
	  		if ($this->politico->getEmail() && SfVoUtil::isEmail($this->politico->getEmail())){
				$mailBody = $this->getPartial('mailTakePolitico', array(
				  	'nombrePolitico' => $this->politico->getNombre(), 
				  	"nombreUsuario" => $this->getUser()->getGuardUser()->getProfile()->getNombreOri() .' '. $this->getUser()->getGuardUser()->getProfile()->getApellidosOri(),
				  	"vanityUsuario" => $this->getUser()->getGuardUser()->getProfile()->getVanity(),
				  	"vanityPolitico" => $this->politico->getVanity()
				));
				VoMail::send(
					sfContext::getInstance()->getI18N()->__('%usuario% ha sido autorizado para editar tu información en Voota', array('%usuario%' => $this->getUser()->getGuardUser()->getProfile()->getNombreOri() .' '. $this->getUser()->getGuardUser()->getProfile()->getApellidosOri())), 
					$mailBody, 
					$this->politico->getEmail(), 
					array('no-reply@voota.es' => 'no-reply Voota'),
					true
				);
	  		}
	  		if(SfVoUtil::isEmail($this->getUser()->getGuardUser()->getUsername()) && (!$this->politico->getEmail() || ($this->politico->getEmail() != $this->getUser()->getGuardUser()->getUsername()))){
				$mailBody = $this->getPartial('mailTakeUsuario', array(
				  	'nombrePolitico' => $this->politico->getNombre(), 
				  	"nombreUsuario" => $this->getUser()->getGuardUser()->getProfile()->getNombreOri() .' '. $this->getUser()->getGuardUser()->getProfile()->getApellidosOri(),
				  	"vanityUsuario" => $this->getUser()->getGuardUser()->getProfile()->getVanity(),
				  	"vanityPolitico" => $this->politico->getVanity()
				));
				VoMail::send(
					sfContext::getInstance()->getI18N()->__('bienvenido a la comunidad de políticos de Voota'), 
					$mailBody, 
					$this->getUser()->getGuardUser()->getUsername(), 
					array('no-reply@voota.es' => 'no-reply Voota'),
					true
				);
	  		}
	  		
	  		
	  		return "Confirm";
	  	}
  	}
  	return "Ask";
  }
  
  public function executeMoreComments(sfWebRequest $request)
  {
  	$id = $request->getParameter("id");
  	$this->t = $request->getParameter("t");
  	$exclude = array();
  	if ($this->t == 1) {
  		/*$this->lastPositives = SfReviewManager::getLastReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, 1, 3);
	    foreach ($this->lastPositives->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}	*/  		
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, 1, BaseSfReviewManager::NUM_REVIEWS-3, $exclude);
  		$this->pageU = $request->getParameter("pageU")+1;
  		$this->getUser()->setAttribute('pageU', $this->pageU);
  	}
  	else {	  
  		/*	
  		$this->lastNegatives = SfReviewManager::getLastReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, -1, 3);
  		foreach ($this->lastNegatives->getResults() as $result){
	  		$exclude[] = $result->getId();
	  	}
	  	*/
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Politico::NUM_ENTITY, $id, -1, BaseSfReviewManager::NUM_REVIEWS-3, $exclude);
  		$this->pageD = $request->getParameter("pageD")+1;
  		$this->getUser()->setAttribute('pageD', $this->pageD);
  	}
  	$this->politico = PoliticoPeer::retrieveByPK( $id );
  }
	
  public function executeIndex(sfWebRequest $request)
  {
    $this->politico_list = PoliticoPeer::doSelect(new Criteria());
  }
  
  private function generateRankingUrl ($partido, $institucion, $p = '', $i = ''){
  	$p_url = "";
  	$i_url = "";
  	$culture = $this->getUser()->getCulture();
  	
  	if ($p != '' && $p != ALL_URL_STRING && $p != ALL_FORM_VALUE){
  		$p_url .= "$p";
  	}
  	else if ($p != ALL_FORM_VALUE && $partido && $partido != ALL_URL_STRING) {
  		$p_url .= "$partido";
  	}
  	
  	if($i != '' && $i != ALL_URL_STRING && $i != ALL_FORM_VALUE){
  		$i_url = "$i";
  	}
  	elseif ($institucion) {
  		$i_url = "$institucion";
  	}
  	
  	if ($p_url == "" && $i_url == ""){
  		// Todos. Sin filtro
  		$url = "politico/ranking";
  	}
  	else if ($p_url != "" && $i_url != ""){
  		// Filtro por partido e institucion
  		$url = "politico/ranking?partido=$p_url&institucion=$i_url";
  	}
  	else if ($i_url == "" ){
  		// Filtro por partido
  		$url = "politico/ranking?partido=$p_url";
  	}
  	else if ($p_url == ""){
  		// Filtro por institucion
  		$url = "politico/ranking?partido=all&institucion=$i_url";
  	}
  	
  	return $url;
  }
  
  public function executeRanking(sfWebRequest $request)
  {
  	$p = $request->getParameter("p");
  	$i = $request->getParameter("i");
  	$culture = $this->getUser()->getCulture("es");
  	$partido = $request->getParameter("partido", false);
  	$institucion = $request->getParameter("institucion", false);

  	$page = $request->getParameter("page", "");
	$order = $request->getParameter("o", "");	
	if ($order == 'pd' || $page == '1' || (!$institucion && $partido == ALL_URL_STRING)){
		$qs = ''; 
		foreach($request->getParameterHolder()->getAll() as $key => $value){
			if ($key != 'module' && $key != 'action' 
					&& !(($order == 'pd' && $key == 'o') || ($page == '1' && $key == 'page')) 
					&& ($key != 'partido' || ($institucion || $partido != ALL_URL_STRING))
					){
				$qs .= ($qs?'&':'?') . "$key=$value";
			}
		}
		$this->redirect( "politico/ranking$qs", 301 );
	}	
	$this->order = $order?$order:'pd';
	$page = $page?$page:1;
   	
   	if (!$partido)
   		$partido = ALL_FORM_VALUE;
   	if (!$institucion)
   		$institucion = ALL_FORM_VALUE;
	
  	$this->partido = ALL_FORM_VALUE;
  	$this->institucion = ALL_FORM_VALUE;
  	
  	if ($p != '' || $i != ''){
	  	$url = $this->generateRankingUrl ($partido, $institucion, $p, $i);
	   	$this->redirect( $url );
  	}
  	$this->partidoAC = '';
    if ($partido && $partido != ALL_URL_STRING){
  		$this->partido = $partido; 
  		
  		$aPartidoCriteria = new Criteria();
  		$aPartidoCriteria->add(PartidoPeer::ABREVIATURA, $this->partido);
  		$aaPartido = PartidoPeer::doSelectOne($aPartidoCriteria);
  		
  		$this->forward404Unless( $aaPartido );
  		$this->partidoAC = $aaPartido->getAbreviatura(). ', ' .$aaPartido->getNombre();
  	}
  	else {
  		$this->partido = ALL_URL_STRING; 
   	}
   	
  	$this->institucionAC = '';
  	if ($institucion && $institucion != ALL_URL_STRING){
  		$this->institucion = $institucion; 
  		
  		$aInstitucionCriteria = new Criteria();
		$aInstitucionCriteria->addJoin(
			array(InstitucionPeer::ID, InstitucionI18nPeer::CULTURE),
			array(InstitucionI18nPeer::ID, "'$culture'")
			, Criteria::INNER_JOIN
		);
		$aInstitucionCriteria->add(InstitucionI18nPeer::VANITY, $this->institucion);
  		$aInstitucion = InstitucionPeer::doSelectOne($aInstitucionCriteria);  		
				
  		$this->forward404Unless( $aInstitucion );
  		
  		if($aInstitucion->getVanity() != $institucion){
  			$url = $this->generateRankingUrl($partido, $aInstitucion->getVanity());
  			$params = $request->getParameterHolder()->getAll();
  			foreach ($params as $key => $value){
  				if ($key != 'module' && $key != 'action' && $key != 'partido' && $key != 'institucion'){
  					$url .= "&$key=$value";
  				}
  			}
  			$this->redirect( $url, 301 );
  		}
  		
  		$this->institucionAC = $aInstitucion->getNombre();
  	} 
  	
  	$filter = array(
  		'type' => 'politico',
  		'partido' => $partido,
  		'institucion' => $institucion,
  		'culture' => $culture,
  		'page' => $page,
  		'order' => $this->order,
  	);
  	$this->getUser()->setAttribute("filter_".Politico::NUM_ENTITY, $filter);
  	$this->politicosPager = EntityManager::getPoliticos($partido, $institucion, $culture, $page, $this->order, EntityManager::PAGE_SIZE, &$totalUp, &$totalDown);
    
    $this->totalUp = $totalUp;
    $this->totalDown = $totalDown;    
  	
	$rule = sfContext::getInstance()->getRouting()->getCurrentRouteName();
  	$params = "";
  	foreach ($request->getParameterHolder()->getAll() as $name => $value){
  		if ($name != 'module' && $name != 'action' && $name != 'o' && $name != 'page'){
  			if ($params === ""){
  				$params .= "?";
  			}
  			else {
  				$params .= "&";
  			}
  			$params .= "$name=$value";
  		}
  	}
  	$this->route = "politico/ranking$params";
  	
  	$this->pageTitle = sfContext::getInstance()->getI18N()->__('Ranking de políticos', array());
  	$this->pageTitle .= $this->partido=='all'?'':', '.$this->partido;
  	$this->pageTitle .= $this->institucion=='0'?'':", ";
  	if (isset($aInstitucion)){
  		$this->pageTitle .= $aInstitucion->getNombre();
  	}
  	
  	switch($this->order){
  		case 'pa':
  			$orderTxt = sfContext::getInstance()->getI18N()->__('votos positivos inverso');
  			break;
  		case 'nd':
  			$orderTxt = sfContext::getInstance()->getI18N()->__('votos negativos');
  			break;
  		case 'na':
  			$orderTxt = sfContext::getInstance()->getI18N()->__('votos negativos inverso');
  			break;
  		default:
  			$orderTxt = sfContext::getInstance()->getI18N()->__('ordenado por votos positivos inverso');
   	}
  	$this->pageTitle .= ", $orderTxt";
  		
  	if ($page && $page != 1) {
  		$this->pageTitle .= " ".sfContext::getInstance()->getI18N()->__('(Pág. %1%)', array('%1%' => $page));
  	}
  	$this->title = $this->pageTitle . ' - Voota';
  	
  	$description = sfContext::getInstance()->getI18N()->__('Ranking de políticos', array());
  	if (isset($aaPartido)){
  		if ($this->partido != '0' && $aaPartido) {
	  		$description .= ", " . $aaPartido->getNombre();
   		}
  	}
  	else {
  		$description .= ", " . sfContext::getInstance()->getI18N()->__('todos los partidos');
  	}
  	if ($this->institucion != '0') {
  		$description .= ", " . $aInstitucion->getNombre()." (". $aInstitucion->getGeo()->getNombre() .", España)";
   	}
   	
  	$description .= ", $orderTxt";
  	if ($page && $page != 1) {
  		$description .= " ".sfContext::getInstance()->getI18N()->__('(Pág. %1%)', array('%1%' => $page));
  	}
  	$this->response->addMeta('Description', $description);
  	
  	
    $this->response->setTitle( $this->title );
  }
  
  public function executeShow(sfWebRequest $request)
  {  	  	  	
  	$vanity = $request->getParameter('id');
  	$s = $request->getParameter('s', 0);
  	
  	$culture = $this->getUser()->getCulture();
  	
  	
  	$c = new Criteria();
  	$c->add(PoliticoPeer::VANITY, $vanity, Criteria::EQUAL);
  	$politico = PoliticoPeer::doSelectOne( $c );
  	$this->forward404Unless( $politico );
  	
  	$this->partido = $request->getParameter("partido");
  	$this->institucion = $request->getParameter("institucion");
  	$this->rankingUrl = $this->generateRankingUrl ($this->partido, $this->institucion);
  	
  	$this->politico = $politico;
  	$id = $this->politico->getId();
  	
  	$this->forward404Unless($this->politico);
  	
  	if ($this->politico->getVanity() != $vanity){
  		$this->redirect('politico/show?id='.$this->politico->getVanity(), 301);
  	}
  	
  	// Estabamos vootando antes del login ?
  	$sfr_status = $this->getUser()->getAttribute('sfr_status', false, 'sf_review');
  	if ($sfr_status){
  		$aSfrStatus = array();
  		foreach ($sfr_status as $key => $value){
  			$aSfrStatus[$key] = $value;
  		}
  		$this->sfr_status = $aSfrStatus;
  		$request->setAttribute('sfr_status', $aSfrStatus);
  		$this->getUser()->setAttribute('sfr_status', false, 'sf_review');
  	}
  	else {
  		$this->getUser()->setAttribute('sfr_status', false, 'sf_review');
  		$this->sfr_status = false;
  	}
	
  	if ($this->politico->getImagen() != ''){
  		$imageFileName = $this->politico->getImagen();
  	}
  	else {
  		$imageFileName = "p_unknown.png";
   	}
	
	$this->image = "bw_$imageFileName";
	
	$pu = $this->getUser()->getAttribute('pageU');
	$pd = $this->getUser()->getAttribute('pageD');
	$c = $this->getUser()->getAttribute('review_c');
	if ($c != '' && $pu != ''){
		$resU = BaseSfReviewManager::NUM_REVIEWS * ($pu-1);
		$this->pageU = $pu;
	}
	else {
		$resU = BaseSfReviewManager::NUM_REVIEWS;
		$this->pageU = 2;
	}	
	if ($c != '' && $pd != ''){
		$resD = BaseSfReviewManager::NUM_REVIEWS * ($pd-1);
		$this->pageD = $pd;		
	}
	else {
		$resD = BaseSfReviewManager::NUM_REVIEWS;
		$this->pageD = 2;		
	}	
	
	
  	$exclude = array();
  	
	$this->positives = SfReviewManager::getReviewsByEntityAndValue($request, 1, $id, 1, $resU);
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue($request, 1, $id, -1, $resD);
	$positiveCount =  $this->positives->getNbResults();
	$negativeCount =  $this->negatives->getNbResults();
	
  	$this->getUser()->setAttribute('pageU', '');
  	$this->getUser()->setAttribute('pageD', '');
	
	$this->totalCount = $positiveCount + $negativeCount;
	if ($this->totalCount > 0) {
		$this->positivePerc = intval( $positiveCount * 100 / $this->totalCount );
		$this->negativePerc = 100 - $this->positivePerc;
	}  
	else {
		$this->positivePerc = 0;
		$this->negativePerc = 0;
	}
  	$this->title = sfContext::getInstance()->getI18N()->__('%1%, opiniones a favor y en contra en Voota'
  					, array(
  						'%1%' => $this->politico->getNombre() . ' '. $this->politico->getApellidos()
  					)
  	);
  	
  	$description = sfContext::getInstance()->getI18N()->__('Página de %1%', array('%1%' => $this->politico->getNombre() . ' '. $this->politico->getApellidos()));
	if (count($this->politico->getPoliticoInstitucions()) > 0) {
  		$description .= " ("; //instituciones
		foreach ($this->politico->getPoliticoInstitucions() as $idx => $politicoInstitucion){
			if ($idx > 0) {
				$description .= ', ';	
			}
			$description .= $politicoInstitucion->getInstitucion()->getNombre();			
		}
	  	$description .= ")";
	}
  	$description .= ", ".$this->politico->getPartido().", "; //partido
  	$description .= sfContext::getInstance()->getI18N()->__('%1% votos a favor y %2% votos en contra.', array('%1%' => $positiveCount, '%2%' => $negativeCount));
    $this->response->addMeta('Description', $description);
  	
    $this->response->setTitle( $this->title );
    
    // Enlaces
    $c = new Criteria();
	$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
	$c->add( $rCriterion );
	if ($politico->getsfGuardUser()){
		$c->add(EnlacePeer::SF_GUARD_USER_ID, $politico->getsfGuardUser()->getId());
	}
	else {
		$c->add(EnlacePeer::POLITICO_ID, $id);
	}
	$c->add(EnlacePeer::URL, '', Criteria::NOT_EQUAL);
    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    if ($politico->getsfGuardUser() && count($this->activeEnlaces) == 0){
	    $c = new Criteria();
		$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
		$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
		$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
		$c->add( $rCriterion );
		$c->add(EnlacePeer::POLITICO_ID, $id);
		$c->add(EnlacePeer::URL, '', Criteria::NOT_EQUAL);
	    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
	    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    }
    
    $this->twitterUser = FALSE;
    foreach ($this->activeEnlaces as $enlace){
    	if (preg_match("/twitter\.com\/(.*)$/is", $enlace->getUrl(), $matches)){
    		$this->twitterUser = $matches[1];
    		break;
    	}
    }
    
    /* paginador */
    $this->politicosPager = EntityManager::getPager($this->politico);
    /* / paginador */
    
    // Feed
    $request->setAttribute('rssTitle',  $this->title. " Feed RSS");
    $request->setAttribute('rssFeed',  'politico/feed?id='.$this->politico->getVanity());
  }

  public function executeFeed(sfWebRequest $request)
  {
  	$vanity = $request->getParameter('id');
  	$culture = $this->getUser()->getCulture();  	
  	  	
  	$c = new Criteria();
  	$c->add(PoliticoPeer::VANITY, $vanity, Criteria::EQUAL);
  	$entity = PoliticoPeer::doSelectOne( $c );
  	$this->forward404Unless( $entity );
  	
	$filter = array();
	$filter['type_id'] = Politico::NUM_ENTITY;
  	$filter['entity_id'] = $entity->getId();
	$reviews = SfReviewManager::getReviews($filter);
  	
  	$title = sfContext::getInstance()->getI18N()->__('%1% en Voota.es'
  					, array(
  						'%1%' => $entity->getNombre() . ' '. $entity->getApellidos()
  					)
  	);
  	$instis = "";
  	foreach ($entity->getPoliticoInstitucions() as $idx => $politicoInstitucion){
  		$instis .= ($instis?", ":"").$politicoInstitucion->getInstitucion();
  	}
  	$description = sfContext::getInstance()->getI18N()->__('Opiniones sobre %1%, %2% votos a favor y %3% votos en contra'
  					, array(
  						'%1%' => $entity->getNombre() . ' '. $entity->getApellidos() . ($instis?" ($instis)":"") . ($entity->getPartido()?", ".$entity->getPartido()."":""),
  						'%2%' => $entity->getSumu(),
  						'%3%' => $entity->getSumd()
  					)
  	);
  	
    $feed = new sfRssFeed();
    $feed->setTitle( $title );
    $feed->setLanguage( $culture );
    $feed->setSubtitle( $description );
    $feed->setDescription( $description );
  	$feed->setLink('politico/show?id='.$entity->getVanity());
  	$domainExt = $culture == 'ca'?"cat":$culture;
  	$feed->setAuthorName("Voota.$domainExt");
  	
  	$feedImage = new sfFeedImage();
	$feedImage->setLink('politico/show?id='.$entity->getVanity());
	$feedImage->setImage(S3Voota::getImagesUrl().'/'.$entity->getImagePath().'/cc_'.$entity->getImagen());
	$feedImage->setTitle( $entity );
	$feed->setImage($feedImage);
  	
  	
  	foreach ($reviews as $review){
	    $item = new sfFeedItem();
	    $item->setTitle(sfContext::getInstance()->getI18N()->__('%1%, voota %2%.', array('%1%' => $review->getSfGuardUser(), '%2%' => $review->getValue()==-1?sfContext::getInstance()->getI18N()->__('en contra'):sfContext::getInstance()->getI18N()->__('a favor'))));
	    $item->setLink('sfReviewFront/show?id='.SfVoUtil::reviewPermalink($review));
	    $item->setAuthorName($review->getSfGuardUser());
	    $item->setPubdate($review->getCreatedAt('U'));
	    $item->setUniqueId($review->getId());
	    
	    $avatar = S3Voota::getImagesUrl().'/usuarios/cc_s_'.$review->getSfGuardUser()->getProfile()->getImagen();
	    $text = ($culture==$review->getCulture()|| !$review->getCulture())?$review->getText():'';
	    $img = $review->getSfGuardUser()->getProfile()->getImagen()?"<img src=\"$avatar\" alt =\"".$review->getSfGuardUser()."\" /> ":"";
	    $content =  "$text"; 
	    
	    $item->setDescription( $content );
	
	    $feed->addItem($item);
	}
  	
  	$this->feed = $feed;
  	
  }
  
}

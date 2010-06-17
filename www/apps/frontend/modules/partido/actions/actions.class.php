<?php

/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * partido actions.
 *
 * @package    Voota
 * @subpackage partido
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

define("ALL_URL_STRING", 'all');
define("ALL_FORM_VALUE", '0');

class partidoActions extends sfActions
{
  public function executeFilter(sfWebRequest $request){
    $culture = $this->getUser()->getCulture();
   	$q = $request->getParameter("q");
    
   	$c = new Criteria();
  	$c->addJoin(PartidoPeer::ID, PartidoI18nPeer::ID);
   	$c->add(PartidoI18nPeer::CULTURE, $culture);
   	
	$rCriterion = $c->getNewCriterion(PartidoPeer::ABREVIATURA, "%$q%", Criteria::LIKE);
	$rCriterion->addOr($c->getNewCriterion(PartidoI18nPeer::NOMBRE, "%$q%", Criteria::LIKE));
	$c->add($rCriterion);
	$c->setLimit( 20 );
	
   	$this->partidos = PartidoPeer::doSelect( $c );
  }
  
  public function executeMoreComments(sfWebRequest $request)
  {
  	$id = $request->getParameter("id");
  	$this->t = $request->getParameter("t");
  	$exclude = array();
  	if ($this->t == 1) {
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, 1, BaseSfReviewManager::NUM_REVIEWS);
  		$this->pageU = $request->getParameter("pageU")+1;
  		$this->getUser()->setAttribute('pageU', $this->pageU);
  	}
  	else {	  	
  		$this->pager = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, -1, BaseSfReviewManager::NUM_REVIEWS);
  		$this->pageD = $request->getParameter("pageD")+1;
  		$this->getUser()->setAttribute('pageD', $this->pageD);
  	}
  	$this->partido = PartidoPeer::retrieveByPK( $id );
  }
  
  private function generateRankingUrl ($institucion, $i = ''){
  	$i_url = "";
  	$culture = $this->getUser()->getCulture();
  	
  	if($i != '' && $i != ALL_URL_STRING && $i != ALL_FORM_VALUE){
  		$i_url = "$i";
  	}
  	elseif ($institucion) {
  		$i_url = "$institucion";
  	}
  	
  	if ($i_url == ""){
  		// Todos. Sin filtro
  		$url = "partido/ranking";
  	}
  	else {
  		// Filtro por institucion
  		$url = "partido/ranking?institucion=$i_url";
  	}
  	
  	return $url;
  }
  
  public function executeRanking(sfWebRequest $request)
  {
  	$culture = sfContext::getInstance()->getUser()->getCulture('es');
  	$institucion = $request->getParameter("institucion");
  	$i = $request->getParameter("i");
  	
  	$page = $request->getParameter("page", "");
	$order = $request->getParameter("o", "");	
	if ($order == 'pd' || $page == '1'){
		$qs = ''; 
		foreach($request->getParameterHolder()->getAll() as $key => $value){
			if ($key != 'module' && $key != 'action' && !(($order == 'pd' && $key == 'o') || ($page == '1' && $key == 'page'))){
				$qs .= ($qs?'&':'?') . "$key=$value";
			}
		}
		$this->redirect( "politico/ranking$qs", 301 );
	}	
    if ($i != ''){
	  	$url = $this->generateRankingUrl ($institucion, $i);
	   	$this->redirect( $url );
  	}
	$this->order = $order?$order:'pd';
	$page = $page?$page:1;
  		
  	$filter = array(
  		'type' => 'partido',
  		'partido' => false,
  		'institucion' => $institucion,
  		'culture' => $culture,
  		'page' => $page,
  		'order' => $this->order,
  	);
  	$this->getUser()->setAttribute("filter_".Partido::NUM_ENTITY, $filter);
  	$this->partidosPager = EntityManager::getPartidos($institucion, $culture, $page, $this->order, EntityManager::PAGE_SIZE, &$totalUp, &$totalDown);
  	 
    $this->totalUp = $totalUp;
    $this->totalDown = $totalDown;
    	
  	$this->institucion = $institucion;
  		$this->institucionAC = '';
  	if ($institucion){ 
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
  			$url = $this->generateRankingUrl($aInstitucion->getVanity());
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
    
    /* Lista de instituciones 
  	$c = new Criteria();
  	$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
  	$c->add(InstitucionPeer::IS_MAIN, true);
  	$this->instituciones = InstitucionPeer::doSelect($c);
  	  Fin Lista de instituciones */
  	
  	//$rule = sfContext::getInstance()->getRouting()->getCurrentRouteName();
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
  	$this->route = "partido/ranking$params";
  	
  	$this->pageTitle = sfContext::getInstance()->getI18N()->__('Ranking de partidos', array());
  	$this->pageTitle .= (!$this->institucion || $this->institucion=='0' || !isset($aInstitucion))?'':", " . $aInstitucion->getNombre();
  	if ($this->order && $this->order != 'pd') {
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
  		}
  		$this->pageTitle .= ", $orderTxt";
   	}
  	if ($page && $page != 1) {
  		$this->pageTitle .= " ".sfContext::getInstance()->getI18N()->__('(Pág. %1%)', array('%1%' => $page));
  	}
  	$this->title = $this->pageTitle . ' - Voota';
  	$this->response->addMeta('Title', $this->title);
  	
  	$description = sfContext::getInstance()->getI18N()->__('Los partidos más votados en Voota:', array()) . " ";
  	if ($this->partidosPager->getNbResults() > 0){
  		foreach ($this->partidosPager->getResults() as $idx => $partido){
  			if ($idx < 5){
  				$description .= ($idx==0?"":", ") . $partido->getAbreviatura();	
  			}  			
  		}
  	}
  	if ($this->partidosPager->getNbResults() > 5){
  		$description .= ', ...';
  	}
  	if ($this->order != 'pd') {
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
  		}
  		$description .= ", $orderTxt";
   	}
  	if ($page && $page != 1) {
  		$description .= " ".sfContext::getInstance()->getI18N()->__('(Pág. %1%)', array('%1%' => $page));
  	}
  	$this->response->addMeta('Description', $description);
  }

  public function executeShow(sfWebRequest $request)
  {
  	$abreviatura = $request->getParameter('id');
  	$culture = $this->getUser()->getCulture("es");
  	
  	$this->institucion = $request->getParameter("institucion");
  	if ($this->institucion == ''){
  		$this->institucion = "0";
  	}
    
  	$c = new Criteria();
  	$c->add(PartidoPeer::ABREVIATURA, $abreviatura , Criteria::EQUAL);
  	$this->partido = PartidoPeer::doSelectOne( $c );
  	
  	$this->forward404Unless( $this->partido );
  	$this->forward404Unless( $this->partido->getIsActive() );
  	
  
  	if ($this->partido->getAbreviatura() != $abreviatura){
  		$this->redirect('partido/show?id='.$this->partido->getAbreviatura(), 301);
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
  	
  	if ($this->partido->getImagen() != ''){
  		$imageFileName = $this->partido->getImagen();
  	}
  	else {
  		$imageFileName = "p_unknown.png";
   	}
	
	$this->image = "cc_$imageFileName";
  	
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
  	
  	$id = $this->partido->getId();
  	
	$this->positives = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, 1, $resU);
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue($request, Partido::NUM_ENTITY, $id, -1, $resD);
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
  	
    // Enlaces
    $c = new Criteria();
	$rCriterion = $c->getNewCriterion(EnlacePeer::CULTURE, null, Criteria::ISNULL);
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, $this->getUser()->getCulture()));
	$rCriterion->addOr($c->getNewCriterion(EnlacePeer::CULTURE, ''));
	$c->add( $rCriterion );
	$c->add(EnlacePeer::PARTIDO_ID, $id);
    $c->addAscendingOrderByColumn(EnlacePeer::ORDEN);
    $this->activeEnlaces = EnlacePeer::doSelect( $c );
    
    $this->twitterUser = FALSE;
    foreach ($this->activeEnlaces as $enlace){
    	if (preg_match("/twitter\.com\/(.*)$/is", $enlace->getUrl(), $matches)){
    		$this->twitterUser = $matches[1];
    		break;
    	}
    }
    
    // Politicos mas votados
    $c = new Criteria();
	$c->addJoin(
		array(PoliticoPeer::ID, PoliticoI18nPeer::CULTURE),
		array(PoliticoI18nPeer::ID, "'$culture'")
		, Criteria::LEFT_JOIN
	);
    
  	$c->add(PoliticoPeer::VANITY, null, Criteria::ISNOTNULL);
  	$c->add(PoliticoPeer::PARTIDO_ID, $this->partido->getId());
  	$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	
  	$this->politicos = new sfPropelPager('Politico', 6);
  	
    $this->politicos->setCriteria($c);
    $this->politicos->init();
    
 	// Lista de instituciones 
  	$c = new Criteria();
  	$c->addJoin(InstitucionPeer::ID, PoliticoInstitucionPeer::INSTITUCION_ID);
  	$c->addJoin(PoliticoInstitucionPeer::POLITICO_ID, PoliticoPeer::ID);
  	$c->addJoin(PoliticoPeer::PARTIDO_ID, PartidoPeer::ID);
  	$c->add(PoliticoPeer::PARTIDO_ID, $this->partido->getId());
  	$c->add(InstitucionPeer::IS_MAIN, true);
  	$c->setDistinct();
  	$c->addAscendingOrderByColumn(InstitucionPeer::ORDEN);
  	$this->instituciones = InstitucionPeer::doSelect($c);
    
  	$this->pageTitle = $this->partido->getNombre() . " (". $this->partido->getAbreviatura().")";
  	$this->title = $this->pageTitle . ' - Voota';
  	$this->response->addMeta('Title', $this->title);

  	$descripcion = $this->partido->getAbreviatura()
  		 . ": "
  		 . sfContext::getInstance()->getI18N()->__('presentación, opiniones de usuarios a favor y en contra, políticos mejor valorados y enlaces. ', array())
  		 . SfVoUtil::cutToLength($this->partido->getPresentacion(), 140, '...', true);
  		 
  	$this->response->addMeta('Descripcion', $descripcion);
  	
 	// Listas de electorales
 	$convocatoriaActiva = sfConfig::get('sf_convocatoria_activa');
  	$this->convocatoria = ConvocatoriaPeer::retrieveByPk($convocatoriaActiva);
 	$c = new Criteria();
 	$c->add(ListaPeer::PARTIDO_ID, $this->partido->getId());
 	$c->add(ListaPeer::CONVOCATORIA_ID, $convocatoriaActiva);
 	$c->addJoin(ListaPeer::GEO_ID, GeoPeer::ID);
 	$c->addAscendingOrderByColumn(GeoPeer::NOMBRE);
	$this->listas = ListaPeer::doSelect( $c );
  	
  	/* paginador */
    $this->partidosPager = EntityManager::getPager($this->partido);
    /* / paginador */
  	    
    // Feed
    $request->setAttribute('rssTitle',  $this->title. " Feed RSS");
    $request->setAttribute('rssFeed',  'partido/feed?id='.$this->partido->getVanity());
    
  }

  public function executeFeed(sfWebRequest $request)
  {
  	$abreviatura = $request->getParameter('id');
  	$culture = $this->getUser()->getCulture("es");
  	
  	$this->institucion = $request->getParameter("institucion");
  	if ($this->institucion == ''){
  		$this->institucion = "0";
  	}
    
  	$c = new Criteria();
  	$c->add(PartidoPeer::ABREVIATURA, $abreviatura , Criteria::EQUAL);
  	$entity = PartidoPeer::doSelectOne( $c );
  	
  	$this->forward404Unless( $entity );
  	$this->forward404Unless( $entity->getIsActive() );
  	
  	
	$filter = array();
	$filter['type_id'] = Partido::NUM_ENTITY;
  	$filter['entity_id'] = $entity->getId();
	$reviews = SfReviewManager::getReviews($filter);
  	
  	$title = sfContext::getInstance()->getI18N()->__('%1% en Voota.es'
  					, array(
  						'%1%' => $entity
  					)
  	);
  	$description = sfContext::getInstance()->getI18N()->__('Opiniones sobre %1%, %2% votos a favor y %3% votos en contra'
  					, array(
  						'%1%' => $entity->getNombre(),
  						'%2%' => $entity->getSumu(),
  						'%3%' => $entity->getSumd()
  					)
  	);
  	
    $feed = new sfRssFeed();
    $feed->setTitle( $title );
    $feed->setLanguage( $culture );
    $feed->setSubtitle( $description );
    $feed->setDescription( $description );
  	$feed->setLink('partido/show?id='.$entity->getVanity());
  	$domainExt = $culture == 'ca'?"cat":$culture;
  	$feed->setAuthorName("Voota.$domainExt");
  	
  	$feedImage = new sfFeedImage();
	$feedImage->setLink('partido/show?id='.$entity->getVanity());
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

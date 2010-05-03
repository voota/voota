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
  	$culture = $this->getUser()->getCulture();
  	
  	$cpos = new Criteria();
  	$cpos->add(SfReviewPeer::VALUE, 1);
  	$cpos->add(SfReviewPeer::IS_ACTIVE, 1);
  	$cpos->add(SfReviewPeer::CULTURE, $culture);
  	$cneg = new Criteria();
  	$cneg->add(SfReviewPeer::VALUE, -1);
  	$cneg->add(SfReviewPeer::IS_ACTIVE, 1);
  	$cneg->add(SfReviewPeer::CULTURE, $culture);
  	
  	$cuser = new Criteria();
  	$cuser->add(sfGuardUserPeer::IS_ACTIVE, 1);
  	
  	$cpol = new Criteria();
  	$cpol->addJoin(PoliticoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
  	$cpol->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Politico::NUM_ENTITY);
  	$cpol->add(SfReviewPeer::IS_ACTIVE, TRUE);
  	$cpol->add(SfReviewPeer::CULTURE, $culture);
  	$cpol->setDistinct();
  	
  	$cpar = new Criteria();
  	$cpar->addJoin(PartidoPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
  	$cpar->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Partido::NUM_ENTITY);
  	$cpar->add(SfReviewPeer::IS_ACTIVE, TRUE);
  	$cpar->add(PartidoPeer::IS_ACTIVE, TRUE);
  	$cpar->add(SfReviewPeer::CULTURE, $culture);
  	$cpar->setDistinct();
  	
  	$cpro = new Criteria();
  	$cpro->addJoin(PropuestaPeer::ID, SfReviewPeer::ENTITY_ID, Criteria::INNER_JOIN);
  	$cpro->add(SfReviewPeer::SF_REVIEW_TYPE_ID, Propuesta::NUM_ENTITY);
  	$cpro->add(SfReviewPeer::IS_ACTIVE, TRUE);
  	$cpro->add(PropuestaPeer::IS_ACTIVE, TRUE);
  	$cpro->add(SfReviewPeer::CULTURE, $culture);
  	$cpro->add(PropuestaPeer::CULTURE, $culture);
  	$cpro->setDistinct();
  	
  	$this->totalUpReviews = SfReviewPeer::doCount($cpos);
  	$this->totalDownReviews = SfReviewPeer::doCount($cneg);
  	$this->topTotalUsers = sfGuardUserPeer::doCount($cuser);
  	$this->topTotalPoliticos = PoliticoPeer::doCount($cpol);
  	$this->topTotalPartidos = PartidoPeer::doCount($cpar);;
  	$this->topTotalPropuestas = PropuestaPeer::doCount($cpro);
	
  	$exclude = "";
	$this->reviewables = EntityManager::getTopEntities(6, $exclude, "WebEntity", true);
	
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(PoliticoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PoliticoPeer::SUMD);
  	$c->setLimit(5);
  	$this->topPoliticos = PoliticoPeer::doSelect($c);
  		
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(PartidoPeer::SUMU);
  	$c->addAscendingOrderByColumn(PartidoPeer::SUMD);
  	$c->setLimit(5);
  	$c->add(PartidoPeer::IS_ACTIVE, true);
  	$this->partidosMasVotados = PartidoPeer::doSelect($c);
  	  		
  	$c = new Criteria();
  	$c->addDescendingOrderByColumn(PropuestaPeer::SUMU);
  	$c->addAscendingOrderByColumn(PropuestaPeer::SUMD);
  	$c->setLimit(5);
  	$c->add(PropuestaPeer::IS_ACTIVE, true);
  	$c->add(PropuestaPeer::CULTURE, $culture);
  	$this->propuestasMasVotadas = PropuestaPeer::doSelect($c);
  	
  	//Totales  	
  	$c = new Criteria();
  	$this->totalPoliticos = PoliticoPeer::doCount($c);
  	$c = new Criteria();
  	$c->add(PartidoPeer::IS_ACTIVE, true);
  	$this->totalPartidos = PartidoPeer::doCount($c);
  	$c = new Criteria();
  	$c->add(PropuestaPeer::IS_ACTIVE, true);
  	$c->add(PropuestaPeer::CULTURE, $culture);
  	$this->totalPropuestas = PropuestaPeer::doCount($c);
	
  	$this->response->addMeta('Description', sfContext::getInstance()->getI18N()->__('Comparte opiniones sobre políticos y partidos de España. Ranking de los políticos y partidos más votados.'));
	
  }
}

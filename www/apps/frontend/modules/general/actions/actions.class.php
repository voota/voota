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
class generalActions extends sfVoActions{

  public function executeAbout(sfWebRequest $request) {
  	$c = new Criteria();
  	//1,2,4,5,6,7
  	$c->add(sfGuardUserPeer::ID, 1);
  	$c->addOr(sfGuardUserPeer::ID, 2);
  	$c->addOr(sfGuardUserPeer::ID, 4);
  	$c->addOr(sfGuardUserPeer::ID, 5);
  	$c->addOr(sfGuardUserPeer::ID, 6);
  	$c->addOr(sfGuardUserPeer::ID, 7);
  	$c->addAscendingOrderByColumn(sfGuardUserPeer::ID);
  	
  	$users = sfGuardUserPeer::doSelect($c);
  	$this->users = array();
  	foreach ($users as $user){
  		$this->users[$user->getid()] = $user;	
  	}
  	
  }
  public function executeSearch(sfWebRequest $request) {
  	
  }
}

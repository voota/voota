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
 * @subpackage review
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */

require_once(sfConfig::get('sf_plugins_dir').'/sfReviewPlugin/modules/sfReviewFront/lib/BasesfReviewFrontActions.class.php');

class sfReviewFrontActions extends BasesfReviewFrontActions
{
	private function updateSums(sfWebRequest $request) {
	  	// Actualizar cache de puntos en politicos
	  	if ($request->getParameter("t") == Politico::NUM_ENTITY){
		  	$this->politico = PoliticoPeer::retrieveByPk($request->getParameter('e'));
		  	$this->politico->setSumu( $this->politico->getPositives() );
		  	$this->politico->setSumd( $this->politico->getNegatives() );
		  	if ($this->politico->isModified()){
		  		PoliticoPeer::doUpdate( $this->politico );
		  	}
	  	}  
	}
	
  public function executeSend(sfWebRequest $request)
  {
  	parent::executeSend( $request );
  	
	$this->updateSums( $request );  	  	
  }
	  public function executeDelete(sfWebRequest $request)
  {
  	parent::executeDelete( $request );
  	
	$this->updateSums( $request );  	  	
  }
}

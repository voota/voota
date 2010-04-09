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
 * @subpackage propuesta
 * @author     Sergio Viteri
 */

class propuestaActions extends sfActions
{
  public function executeRanking(sfWebRequest $request)
  {
  }
  
  public function executeNew(sfWebRequest $request)
  {
  	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
  }
  
  public function executeShow(sfWebRequest $request)
  {
  	$id = $this->request->getParameter("id");
  	
  	$propuesta = PropuestaPeer::retrieveByPk( $id );
  	$this->forward404Unless( $propuesta );
  }
}

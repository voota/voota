<?php

/**
 * eleccion actions.
 *
 * @package    sf_sandbox
 * @subpackage eleccion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eleccionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
  	$id = $request->getParameter('id');
  	
  	$c = new Criteria();
  	$c->add(EleccionPeer::ID, $id);
  	$this->eleccion = EleccionPeer::doSelectOne($c);
  	$this->forward404Unless( $this->eleccion );
  }
}

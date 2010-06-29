<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once dirname(__FILE__).'/../lib/eleccionGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eleccionGeneratorHelper.class.php';

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class eleccionActions extends autoEleccionActions
{	
	public function executeAutoComplete($request)
	{
	  $this->getResponse()->setContentType('application/json');
	  $instituciones = InstitucionI18nPeer::retrieveForAutoSelect($request->getParameter('q'), $request->getParameter('limit'));
	  return $this->renderText(json_encode($instituciones));
	}
	
	public function executeEdit(sfWebRequest $request) {
		$this->configuration->setInstituciones($this->getRoute()->getObject()->getEleccionInstitucions());		
		
		parent::executeEdit( $request );
		$this->form->setOption('url', $this->getController()->genUrl('eleccion/autoComplete'));	
		$this->form->configure();
	}
	
	public function executeDeleteInstitucion(sfWebRequest $request) {
	  $institucion = EleccionInstitucionPeer::retrieveByPK($request->getParameter('idm'), $request->getParameter('idi'));
	  $institucion->delete();
	  $this->redirect('@eleccion_edit?id='.$institucion->getEleccionId());
	}
}

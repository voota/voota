<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__).'/../lib/listaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/listaGeneratorHelper.class.php';

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class listaActions extends autoListaActions
{
	public function executeAutoComplete($request)
	{
	  $this->getResponse()->setContentType('application/json');
	  $politicos = PoliticoPeer::retrieveForAutoSelect($request->getParameter('q'), $request->getParameter('limit'));
	  return $this->renderText(json_encode($politicos));
	}
	public function executeAutoCompleteCo($request)
	{
	  $this->getResponse()->setContentType('application/json');
	  $convocatorias = ConvocatoriaPeer::retrieveForAutoSelect($request->getParameter('q'), $request->getParameter('limit'));
	  return $this->renderText(json_encode($convocatorias));
	}
	public function executeAutoCompleteCi($request)
	{
	  $this->getResponse()->setContentType('application/json');
	  $circunscripciones = CircunscripcionPeer::retrieveForAutoSelect($request->getParameter('q'), $request->getParameter('limit'));
	  return $this->renderText(json_encode($circunscripciones));
	}
	
	public function executeEdit(sfWebRequest $request) {
		//$this->configuration->setEnlaces($this->getRoute()->getObject()->getEnlaces());		
		$this->configuration->setPoliticos($this->getRoute()->getObject()->getPoliticoListas());		
		
		parent::executeEdit( $request );
		$this->form->setOption('url', $this->getController()->genUrl('lista/autoComplete'));
		$this->form->setOption('url_co', $this->getController()->genUrl('lista/autoCompleteCo'));	
		$this->form->setOption('url_ci', $this->getController()->genUrl('lista/autoCompleteCi'));	
		$this->form->configure();
	}
	
	public function executeDeleteInstitucion(sfWebRequest $request) {
	  $politico = PoliticoListaPeer::retrieveByPK($request->getParameter('idi'), $request->getParameter('idm'));
	  $politico->delete();
	  $this->redirect('@lista_edit?id='.$politico->getListaId());
	}
}

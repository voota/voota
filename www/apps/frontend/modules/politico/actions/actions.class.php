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
class politicoActions extends sfVoActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->politico_list = PoliticoPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {  	  	
  	$id = $request->getParameter('id');
  	$this->politico = PoliticoPeer::retrieveByPk($request->getParameter('id'));
  	$this->forward404Unless($this->politico);
  	
  	// Estabamos vootando antes del login ?
  	$v = $this->getUser()->getAttribute('review_v');
  	if ($v && $v != ''){
  		$e = $this->getUser()->getAttribute('review_e');
  		$this->getUser()->setAttribute('review_v', '');
  		$this->getUser()->setAttribute('review_e', '');
  		
  		if ($e == $id && $this->getUser()->isAuthenticated()) {
  			$this->review_v = $v;
  		}	
  	} 	
    
	$imageFileName = sfConfig::get('sf_upload_dir').'/politicos/'.$this->politico->getImagen();
	if (file_exists($imageFileName)){
		$img = new sfImage( $imageFileName );
		$img->voota( $imageFileName );
		
		$this->image = "bw_" . $this->politico->getImagen();
	}
	else {
		// Sin imagen: Imagen genérica Voota
	}
	
	$this->positives = SfReviewManager::getReviewsByEntityAndValue(1, $id, 1);
	$this->negatives = SfReviewManager::getReviewsByEntityAndValue(1, $id, -1);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PoliticoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PoliticoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($politico = PoliticoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object politico does not exist (%s).', $request->getParameter('id')));
    $this->form = new PoliticoForm($politico);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($politico = PoliticoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object politico does not exist (%s).', $request->getParameter('id')));
    $this->form = new PoliticoForm($politico);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($politico = PoliticoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object politico does not exist (%s).', $request->getParameter('id')));
    $politico->delete();

    $this->redirect('politico/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $politico = $form->save();

      $this->redirect('politico/edit?id='.$politico->getId());
    }
  }
}

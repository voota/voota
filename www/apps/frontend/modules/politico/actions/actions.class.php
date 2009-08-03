<?php

/**
 * politico actions.
 *
 * @package    sf_sandbox
 * @subpackage politico
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class politicoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->politico_list = PoliticoPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->politico = PoliticoPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->politico);
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

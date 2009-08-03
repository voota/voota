<?php

/**
 * partido actions.
 *
 * @package    sf_sandbox
 * @subpackage partido
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class partidoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->partido_list = PartidoPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->partido = PartidoPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->partido);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PartidoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PartidoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($partido = PartidoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object partido does not exist (%s).', $request->getParameter('id')));
    $this->form = new PartidoForm($partido);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($partido = PartidoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object partido does not exist (%s).', $request->getParameter('id')));
    $this->form = new PartidoForm($partido);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($partido = PartidoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object partido does not exist (%s).', $request->getParameter('id')));
    $partido->delete();

    $this->redirect('partido/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $partido = $form->save();

      $this->redirect('partido/edit?id='.$partido->getId());
    }
  }
}

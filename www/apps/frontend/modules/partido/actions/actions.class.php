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
class partidoActions extends sfActions
{
  public function executeRanking(sfWebRequest $request)
  {
    $this->partido_list = PartidoPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->partido = PartidoPeer::retrieveByPk($request->getParameter('id'));
  }
}

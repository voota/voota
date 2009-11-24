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
class voBaseFilter extends sfFilter
{
  public function execute ($filterChain)
  {
  	$response = $this->getContext()->getResponse();
    $response->setTitle('Voota. '.sfContext::getInstance()->getI18N()->__('Tú tienes la última palabra', array()));
    //$response->addMeta('Subject', sfContext::getInstance()->getI18N()->__('Tú tienes la última palabra', array()));
    //$response->addMeta('Description', sfContext::getInstance()->getI18N()->__('Coomparte opiniones sobre los políticos de España', array()));
    //$response->addMeta('Keywords', sfContext::getInstance()->getI18N()->__('Política, Políticos, Partidos, Congreso, Senado, Parlamento de Cataluña', array()));
    //$response->addMeta('Language', sfContext::getInstance()->getUser()->getCulture());
    //$response->addMeta('Distribution', 'Global');
	$response->addMeta('Robots', 'All');

  	// Execute next filter
    $filterChain->execute();  	
  }
}

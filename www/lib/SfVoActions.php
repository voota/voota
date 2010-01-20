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
class SfVoActions extends sfActions
{
	protected function checkUser() {
	  if (! $this->getUser()->isAuthenticated() ) {
  		$this->getUser()->setFlash('notice_type', 'warning', true);
	    $this->getUser()->setFlash(
	    	'notice', 
			sfContext::getInstance()->getI18N()->__('Quieto parao. Para esto necesitas tener una cuenta en Voota. Si no tienes cuenta aun, este es el mejor momento!', array(), 'notices')
			, true
		);
  		$this->getUser()->setAttribute('url_back', sfContext::getInstance()->getRouting()->getCurrentInternalUri());
  	  }
  	  $this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
	}
}
 
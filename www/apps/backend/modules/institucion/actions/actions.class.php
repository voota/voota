<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once dirname(__FILE__).'/../lib/institucionGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/institucionGeneratorHelper.class.php';

/**
 * politico actions.
 *
 * @package    Voota
 * @subpackage politico
 * @author     Sergio Viteri
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class institucionActions extends autoInstitucionActions
{
	/*public function executeUpdate(sfWebRequest $request) {
		$institucion = $this->getRoute()->getObject();
	    if ($institucion->getVanity() == ''){
	    	$vanityUrl = SfVoUtil::encodeVanity($institucion->getNombreCorto());
	    	
		    $c2 = new Criteria();
		    $c2->add(InstitucionPeer::VANITY, "$vanityUrl%", Criteria::LIKE);
		    $c2->add(InstitucionPeer::ID, $institucion->getId(), Criteria::NOT_EQUAL);
		    $usuariosLikeMe = InstitucionPeer::doSelect( $c2 );
		    $counter = 0;
		    foreach ($usuariosLikeMe as $usuarioLikeMe){
		    	$counter++;
		    }
		    $institucion->setVanity( "$vanityUrl". ($counter==0?'':"-$counter") );
		    
		    
    		$this->form = $this->configuration->getForm($institucion);

    		$this->processForm($request, $this->form);

    		$this->setTemplate('edit');
		    
	    }
	}*/
}

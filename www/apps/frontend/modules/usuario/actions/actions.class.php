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
define("ALL_URL_STRING", 'all');
define("ALL_FORM_VALUE", '0');

class usuarioActions extends sfVoActions
{
	
  public function executeEdit(sfWebRequest $request)
  {
	$this->redirectUnless( $this->getUser()->isAuthenticated(), "@sf_guard_signin" );
	if ($this->getRequest('email') != ''){
		$file = $request->getFiles('image');
		if ($file && $file['tmp_name'] != '' && file_exists($file['tmp_name'])){
			$arr = array_reverse( split("\.", $file['name']) );
			$ext = $arr[0]; 
			$fileName = sfConfig::get('sf_upload_dir').'/usuarios/' . $this->getUser()->getProfile()->getVanity() . ".$ext";
			
			move_uploaded_file($file['tmp_name'], $fileName);
			
			$img = new sfImage( $fileName );
	
			$img->usuario($file);
			$this->getUser()->getProfile()->setImagen($this->getUser()->getProfile()->getVanity() . ".$ext");
	  		//sfGuardUserProfilePeer::doUpdate( $this->getUser()->getProfile() );
		}
	}
	
  }
}

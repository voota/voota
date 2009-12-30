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
  public function executeUpdate(sfWebRequest $request)
  {
    $this->institucion = $this->getRoute()->getObject();
  	$this->form = $this->configuration->getForm($this->institucion);
  	
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
  	if ($this->form->isValid()) {
	  	$imagen = $this->form->getValue('imagen');
	    if ($imagen && $imagen->getOriginalName()){
			$arr = array_reverse( split("\.", $imagen->getOriginalName()) );
			$ext = strtolower($arr[0]);
			if (!$ext || $ext == ""){
			  	$ext = "png";
			}     
		    $imageName = $this->form->getValue('vanity');
		      
		    $imageName .= ".$ext";
		    $imagen->save(sfConfig::get('sf_upload_dir').'/instituciones/'.$imagen->getOriginalName());
		    $this->form->getObject()->setImagen( $imagen->getOriginalName() );
	    }
    }
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
	public function executeIndex(sfWebRequest $request){
		echo $this->getUser()->getCulture();
		parent::executeIndex($request);
	}

}

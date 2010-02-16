<?php

/**
 * politico module configuration.
 *
 * @package    sf_sandbox
 * @subpackage politico
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class politicoGeneratorConfiguration extends BasePoliticoGeneratorConfiguration
{
	var $enlaces;
	var $instituciones;
	
  public function getFormDisplay()
  {
  	$ret = parent::getFormDisplay();
  	if (isset($this->enlaces)){
	  	$enlacesDisplay = array();
	  	foreach ($this->enlaces as $enlace){
	  		$enlacesDisplay[] = 'enlace'. $enlace->getId();
	  	}
	  	$enlacesDisplay[] = 'enlace';
	  	$ret['Enlaces'] = $enlacesDisplay;
  	}
  	if (isset($this->instituciones)){
	  	$institucionesDisplay = array();
	  	foreach ($this->instituciones as $institucion){
	  		$institucionesDisplay[] = 'institucion'. $institucion->getInstitucion()->getId();
	  	}
	  	$institucionesDisplay[] = 'institucion';
	  	$ret['Instituciones'] = $institucionesDisplay;
  	}
    return $ret;
  }
  public function setEnlaces( $enlaces )
  {
  	$this->enlaces = $enlaces;
  }
  public function setInstituciones( $instituciones )
  {
  	$this->instituciones = $instituciones;
  }
  
}

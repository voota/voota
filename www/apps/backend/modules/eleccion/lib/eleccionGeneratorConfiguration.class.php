<?php

/**
 * eleccion module configuration.
 *
 * @package    sf_sandbox
 * @subpackage eleccion
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class eleccionGeneratorConfiguration extends BaseEleccionGeneratorConfiguration
{
	var $instituciones;
	
  public function getFormDisplay()
  {
  	$ret = parent::getFormDisplay();
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
  public function setInstituciones( $instituciones )
  {
  	$this->instituciones = $instituciones;
  }
}

<?php

/**
 * partido module configuration.
 *
 * @package    sf_sandbox
 * @subpackage partido
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class partidoGeneratorConfiguration extends BasePartidoGeneratorConfiguration
{
	var $enlaces;
	
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
    return $ret;
  }
  public function setEnlaces( $enlaces )
  {
  	$this->enlaces = $enlaces;
  }
}

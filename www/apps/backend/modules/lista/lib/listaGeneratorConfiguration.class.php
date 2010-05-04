<?php

/**
 * lista module configuration.
 *
 * @package    sf_sandbox
 * @subpackage lista
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class listaGeneratorConfiguration extends BaseListaGeneratorConfiguration
{
	var $politicos;
	
  public function getFormDisplay()
  {
  	$ret = parent::getFormDisplay();
  	if (isset($this->politicos)){
	  	$politicosDisplay = array();
	  	foreach ($this->politicos as $politico){
	  		$politicosDisplay[] = 'politico'. $politico->getPolitico()->getId();
	  	}
	  	$politicosDisplay[] = 'politico';
	  	$ret['Politicos'] = $politicosDisplay;
  	}
    return $ret;
  }
  public function setPoliticos( $politicos )
  {
  	$this->politicos = $politicos;
  }
}

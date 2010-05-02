<?php

class SfGuardUserProfile extends BaseSfGuardUserProfile
{
	var $ori = false;
	
	public function setOri( $ori ){
		$this->ori = $ori;
	}
	
  public function __toString()
  {
    return $this->getSfGuardUser()->getUsername();
  }
  
  private function getPolitico(){
  	$politico = false;
  	if ($this->getsfGuardUser()){
	  	$politicos = $this->getsfGuardUser()->getPoliticos();
	  	if ($politicos && count($politicos) > 0){
	  		$politico = $politicos[0]; 
	  	}
  	}
  	
  	return $politico;
  }
  
  public function getNombre() {
  	$politico = $this->getPolitico();
  
  	return ($politico && !$this->ori)?$politico->getNombre():parent::getNombre();
  }
  
  public function getApellidos() {
  	$politico = $this->getPolitico();
  
  	return ($politico && !$this->ori)?$politico->getApellidos():parent::getApellidos();
  }
  
  public function getNombreOri() {
  
  	return parent::getNombre();
  }
  
  public function getApellidosOri() {
  
  	return parent::getApellidos();
  }
  /*
  public function getVanity() {
  	return SfVoUtil::fixVanityChars(parent::getVanity());
  }
  */
}

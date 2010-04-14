<?php

class SfGuardUserProfile extends BaseSfGuardUserProfile
{
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
  
  	return $politico?$politico->getNombre():parent::getNombre();
  }
  
  public function getApellidos() {
  	$politico = $this->getPolitico();
  
  	return $politico?$politico->getApellidos():parent::getApellidos();
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

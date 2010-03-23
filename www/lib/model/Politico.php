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
class Politico extends BasePolitico implements reviewable
{
	const NUM_ENTITY = 1;
	
  public function __toString()
  {
    return $this->getNombre() . ' ' . $this->getApellidos();
  }

  public function getLongName()
  {
    return SfVoUtil::cutToLength("".$this->__toString(), 35) . ($this->getPartido()?" (" . $this->getPartido() .")":'');
  }
  
  public function getPositives() {
  	return SfReviewManager::getTotalReviewsByEntityAndValue(1, $this->getId(), 1);
  }
  
  public function getNegatives(){
  	return SfReviewManager::getTotalReviewsByEntityAndValue(1, $this->getId(), -1);
  }
  
  	public function applyDefaultValues()
	{
		if ($this->sumu == null || $this->sumu == ''){
			$this->sumu = 0;
		}
		if ($this->sumd == null || $this->sumd == ''){
			$this->sumd = 0;
		}
	}
  
	var $sumut = 0;
	var $sumdt = 0;
	public function getSumut(){
		return $this->sumut;
	}
	public function setSumut($v){
		return $this->sumut = $v;
	}
	public function getSumdt(){
		return $this->sumdt;
	}
	public function setSumdt($v){
		return $this->sumdt = $v;
	}
	
	public function getTotalt(){
		return $this->sumut + $this->sumdt;
	}
	public function getPath(){
		return 'politicos';
	}
	public function getModule(){
		return 'politico';
	}
	public function getImagen(){
		if ($this->getsfGuardUser() && $this->getsfGuardUser()->getProfile()->getImagen()){
			return $this->getsfGuardUser()->getProfile()->getImagen();
		}
		else {
			$img = parent::getImagen();
			return $img?$img:'p_unknown.png';
		}
	}
	public function getImagePath(){
		if ($this->getsfGuardUser() && $this->getsfGuardUser()->getProfile()->getImagen()){
			return "usuarios";
		}
		else {
			return "politicos";
		}
	}
	
  public function getType()
  {
    return self::NUM_ENTITY;
  }
}

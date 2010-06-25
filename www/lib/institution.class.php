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
class Institution {
	var $id;
	var $vanity;
	var $name;
	var $longName;
	
  	public function __construct()
  	{
  	} 

  	public function __toString(){
  		return $this->longName;
  	}
  	public function getId(){
  		return $this->id;
  	}
  	public function getVanity(){
  		return $this->vanity;
  	}
	public function getName(){
  		return $this->name;
  	}
  	public function getLongName(){
  		return $this->longName;
  	}
  	public function setId( $id ){
  		$this->id = $id;
  	}
  	public function setVanity( $vanity ){
  		$this->vanity = $vanity;
  	}
  	public function setName( $name ){
  		$this->name = $name;
  	}
  	public function setLongName( $name ){
  		$this->longName = $name;
  	}
}
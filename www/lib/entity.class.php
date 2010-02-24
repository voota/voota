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
class Entity implements reviewable {
	var $type = 'unknown';
	var $nombre;
	
  	public function __construct($entity)
  	{
  		$this->nombre = $entity->__toString();
  		$peer = $entity->getPeer();
  		$this->type = $peer::TABLE_NAME;
  	}
    public function getNombre(){
    	return $entity;
    }
    public function getSumu(){
    	
    }
    public function getSumd(){
    	
    }
	public function getSumut(){
		
	}
	public function setSumut($v){
		
	}
	public function getSumdt(){
		
	}
	public function setSumdt($v){
		
	}
	public function getTotalt(){
		
	}
	public function getImagen(){
		
	}
	public function getLongName(){
		
	}
	public function getVanity(){
		
	}
	public function getPath(){
		
	}
	public function getModule(){
		
	}  
  
}
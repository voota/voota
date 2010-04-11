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
class WebEntity extends Entity implements reviewable {
	const IMAGE_PATH = 'http://images.voota.es/';
		
	var $imagePath;
	var $module;
	var $sumut;
	var $sumdt;
	var $imagen;
	var $sumu;
	var $sumd;
	var $totalt;
	var $path;
	
  	public function __construct(reviewable $entity)
  	{
  		parent::__construct( $entity );
  	
  	  	$this->imagePath = $entity->getImagePath();
  	  	$this->module = $entity->getModule();
  	  	$this->sumut = $entity->getSumut();
  	  	$this->sumdt = $entity->getSumdt();
  	  	$this->imagen = $entity->getImagen();
  	  	$this->type = $entity->getType();
  	} 


  	public function getId(){
  		return $this->id;
  	}
  	public function getImagePath(){
  		return $this->imagePath;
  	}
  	public function getImagen(){
  		return $this->imagen;
  	}
  	public function getLongName(){
  		return $this->longName;
  	}
  	public function getModule(){
  		return $this->module;
  	}
  	public function getSumut(){
  		return $this->sumut;
  	}
  	public function getSumdt(){
  		return $this->sumdt;
  	}
  	public function setSumut( $val ){
  		$this->sumut = $val;
  	}
  	public function setSumdt( $val ){
  		$this->sumdt = $val;
  	}
  	public function getSumu(){
  		return $this->sumu;
  	}
  	public function getSumd(){
  		return $this->sumd;
  	}
  	public function getTotalt(){
  		return $this->totalt;
  	}
  	public function getPath(){
  		return $this->path;
  	}
  	public function updateCalcs(){
  	}
}

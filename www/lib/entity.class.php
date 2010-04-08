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
class Entity {
	const IMAGE_PATH = 'http://imagesvoota.s3.amazonaws.com/';
	
	var $type = 'unknown';
	var $id;
	var $name;
	var $longName;
	var $imagen;
	var $image;
	var $image_s;
	var $image_bw;
	var $image_s_bw;
	var $positives;
	var $negatives;
	var $description;
	var $vanity;
	var $imagePath;
	var $module;
	
  	public function __construct(reviewable $entity)
  	{
  		$this->id = $entity->getId();
  		$this->name = $entity->__toString();
  		$peer = $entity->getPeer();
  		$this->type = $peer::TABLE_NAME;
  		$this->positives = $entity->getSumu();
  		$this->negatives = $entity->getSumd();
  		$this->image = self::IMAGE_PATH . $this->type . "s/cc_" . $entity->getImagen();
  		$this->image_s = self::IMAGE_PATH . $this->type . "s/cc_s_" . $entity->getImagen();
  		$this->image_bw = self::IMAGE_PATH . $this->type . "s/bw_" . $entity->getImagen();
  	  	$this->image_s_bw = self::IMAGE_PATH . $this->type . "s/bw_s_" . $entity->getImagen();
  	  	$this->longName = $entity->getLongName();
  	  	$this->recentPositives = $entity->getSumut();
  	  	$this->recentNegatives = $entity->getSumdt();
  	  	$this->vanity = $entity->getVanity();
  	  	$this->imagePath = $entity->getImagePath();
  	  	$this->module = $entity->getModule();
  	  	$this->sumut = $entity->getSumut();
  	  	$this->sumdt = $entity->getSumdt();
  	  	$this->imagen = $entity->getImagen();
  	} 

  	public function __toString(){
  		return $this->getLongName();
  	}
  	public function getType(){
  		return $this->type;
  	}
  	public function getVanity(){
  		return $this->vanity;
  	}
  	public function getId(){
  		return $this->vanity;
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
}
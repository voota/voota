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
	const IMAGE_PATH = 'http://images.voota.es/';
	
	var $type = 'unknown';
	var $id;
	var $name;
	var $longName;
	var $image;
	var $image_s;
	var $image_bw;
	var $image_s_bw;
	var $positives;
	var $negatives;
	var $recentPositives;
	var $recentNegatives;
	var $description;
	var $vanity;
	
  	public function __construct(reviewable $entity)
  	{
  		$this->id = $entity->getId();
  		$this->name = $entity->__toString();
  		$peer = $entity->getPeer();
  		$tableMap = call_user_func_array(array($entity->getPeer(), 'getTableMap'), array());
  		$this->type = $tableMap->getName();
  		$this->positives = $entity->getSumu();
  		$this->negatives = $entity->getSumd();
  		$this->image = self::IMAGE_PATH . $entity->getImagePath() . "/cc_" . $entity->getImagen();
  		$this->image_s = self::IMAGE_PATH . $entity->getImagePath() . "/cc_s_" . $entity->getImagen();
  		$this->image_bw = self::IMAGE_PATH . $entity->getImagePath() . "/bw_" . $entity->getImagen();
  	  	$this->image_s_bw = self::IMAGE_PATH . $entity->getImagePath() . "/bw_s_" . $entity->getImagen();
  	  	$this->longName = $entity->getLongName();
  	  	$this->recentPositives = $entity->getSumut();
  	  	$this->recentNegatives = $entity->getSumdt();
  	  	$this->vanity = $entity->getVanity();
  	  	$this->description = $entity->getDescription();
  	} 

  	public function __toString(){
  		return $this->longName;
  	}
  	public function getType(){
  		return $this->type;
  	}
  	public function getVanity(){
  		return $this->vanity;
  	}
}
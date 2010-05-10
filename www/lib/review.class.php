<?php
/*
 * This file is part of the Voota package.
 * (c) 2009 Sergio Viteri <sergio@voota.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    Voota
 * @subpackage sfReview
 * @author     Sergio Viteri
 */
class Review {
	var $type = 'unknown';
	var $id;
	var $value;
	var $text;
	
  	public function __construct($sfReview)
  	{
  		$this->id = $sfReview->getId();
  		$this->type = $sfReview->getSfReviewType()->getModule();
  		$this->value = $sfReview->getValue();
  		$this->text = $sfReview->getText();
  	} 
}
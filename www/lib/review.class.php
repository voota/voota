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
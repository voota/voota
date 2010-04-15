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
class sfImageVootaGD extends sfImageTransformAbstract
{
		
  // Parameters can be passed in the standard way
  public function __construct()
  {
	define("IMG_MAX_WIDTH", 180);
	define("IMG_MAX_HEIGHT", 240);
	define("IMG_SMALL_WIDTH", 36);
	define("IMG_SMALL_HEIGHT", 36);
	define("IMG_RATIO", 0.75);
  	
  }
  
  public function transform(sfImage $img)
  {
	$this->directory = dirname($img->getFilename());
	$arr = array_reverse( explode("/", $img->getFilename()) );
	$this->fileName = $arr[0];
	$arr2 = explode(".", $this->fileName);
	if (count( $arr2 ) == 1){
		$this->fileName .= '.png';
	}
	
	$destDir = '/tmp';
	
	$ccFile = $destDir . DIRECTORY_SEPARATOR.'cc_'.$this->fileName;
	$bwFile = $destDir . DIRECTORY_SEPARATOR.'bw_'.$this->fileName;
	$ccSmallFile = $destDir . DIRECTORY_SEPARATOR.'cc_s_'.$this->fileName;
	$bwSmallFile = $destDir . DIRECTORY_SEPARATOR.'bw_s_'.$this->fileName;
	
	
  	if(!file_exists($destDir)) {
  		mkdir($destDir);
  	}
  	
  	if ($img->getWidth() > IMG_MAX_WIDTH || $img->getHeight() > IMG_MAX_HEIGHT){
  		if ($img->getWidth() > $img->getHeight() * IMG_RATIO) {
  			$img->resize(IMG_MAX_WIDTH, null);
  		}
  		else {
  			$img->resize(null, IMG_MAX_HEIGHT);
  		}
  	}
	$img->saveAs( $ccFile );
  	
	$img->greyscale()->saveAs( $bwFile );

	
	$smallImg = new sfImage( $ccFile );
	
  	if ($smallImg->getWidth() > IMG_SMALL_WIDTH || $smallImg->getHeight() > IMG_SMALL_WIDTH){
  		if ($smallImg->getWidth() > $img->getHeight() * IMG_RATIO) {
  			$smallImg->resize(null, IMG_MAX_HEIGHT);
  		}
  		else {
  			$smallImg->resize(IMG_MAX_WIDTH, null);
  		}
  	}
  	
 	if ($smallImg->getWidth() > IMG_SMALL_WIDTH || $smallImg->getHeight() > IMG_SMALL_HEIGHT){
  		if ($smallImg->getWidth() > $smallImg->getHeight() * IMG_RATIO) {
  			$smallImg->resize(null, IMG_SMALL_HEIGHT);
  		}
  		else {
  			$smallImg->resize(IMG_SMALL_WIDTH, null);
  		}
  	}
	$x1 = ($smallImg->getWidth() - IMG_SMALL_WIDTH) / 2;
	$y1 = ($smallImg->getHeight() - IMG_SMALL_HEIGHT) / 3;
	$smallImg->crop($x1, $y1, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT)->saveAs( $ccSmallFile );
	
	$smallImg->greyscale()->saveAs( $bwSmallFile );
			
  	  	
  }  
  

}

?>
<?php

class sfImageVootaGD extends sfImageTransformAbstract
{
		
  // Parameters can be passed in the standard way
  public function __construct()
  {
	define("IMG_MAX_WIDTH", 180);
	define("IMG_MAX_HEIGHT", 240);
	define("IMG_RATIO", 0.75);
  	
  }
	
  public function transform(sfImage $img)
  {
	$this->directory = dirname($img->getFilename());
	$arr = array_reverse( split("/", $img->getFilename()) );
	$this->fileName = $arr[0];
	
	$destDir = sfConfig::get('sf_web_dir'). DIRECTORY_SEPARATOR. 'images'.DIRECTORY_SEPARATOR.'politicos';
	$ccFile = $destDir . DIRECTORY_SEPARATOR.'cc_'.$this->fileName;
	$bwFile = $destDir . DIRECTORY_SEPARATOR.'bw_'.$this->fileName;
	
  	if(!file_exists($destDir)) {
  		mkdir($destDir);
  	}

  	if (
  		!file_exists($ccFile) || !file_exists($bwFile)
  		|| filemtime ( $ccFile ) < filemtime( $img->getFilename() )
  		|| filemtime ( $bwFile ) < filemtime( $img->getFilename() )
  		) {
  			/*
		  	$img->overlay(
		  		new sfImage(
		  			sfConfig::get('sf_web_dir'). DIRECTORY_SEPARATOR. 'images'. DIRECTORY_SEPARATOR. 'wm.png'
		  		)
		  	);
		  	*/
  			if ($img->getWidth() > IMG_MAX_WIDTH || $img->getHeight() > IMG_MAX_HEIGHT){
  				if ($img->getWidth() > $img->getHeight() * IMG_RATIO) {
  					$img->resize(IMG_MAX_WIDTH, null);
  				}
  				else {
  					$img->resize(null, IMG_MAX_HEIGHT);
  				}
  			}
			$img->saveAs( $ccFile );
		  	
			$img->greyscale();
			$img->saveAs( $bwFile );  			
  	}  	
  }  

}

?>
<?php

class sfImageUsuarioGD extends sfImageVootaGD
{
		
  public function transform(sfImage $img)
  {
	$this->directory = dirname($img->getFilename());
	$arr = array_reverse( split("/", $img->getFilename()) );
	$this->fileName = $arr[0];
	$arr2 = split("\.", $this->fileName);
	if (count( $arr2 ) == 1){
		$this->fileName .= '.png';
	}
	
	$destDir = '/tmp';
	
	$ccFile = $destDir . DIRECTORY_SEPARATOR.'cc_'.$this->fileName;
	$ccSmallFile = $destDir . DIRECTORY_SEPARATOR.'cc_s_'.$this->fileName;
	
  	if(!file_exists($destDir)) {
  		mkdir($destDir);
  	}

  	if (
  		!file_exists($ccFile) || !file_exists($ccSmallFile)
  		|| filemtime ( $ccFile ) < filemtime( $img->getFilename() )
  		|| filemtime ( $ccSmallFile ) < filemtime( $img->getFilename() )
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
		  	
  			if ($img->getWidth() > IMG_SMALL_WIDTH || $img->getHeight() > IMG_SMALL_WIDTH){
  				if ($img->getWidth() > $img->getHeight() * IMG_RATIO) {
  					$img->resize(null, IMG_MAX_HEIGHT);
  				}
  				else {
  					$img->resize(IMG_MAX_WIDTH, null);
  				}
  			}
  			
 			if ($img->getWidth() > IMG_SMALL_WIDTH || $img->getHeight() > IMG_SMALL_HEIGHT){
  				if ($img->getWidth() > $img->getHeight() * IMG_RATIO) {
  					$img->resize(null, IMG_SMALL_HEIGHT);
  				}
  				else {
  					$img->resize(IMG_SMALL_WIDTH, null);
  				}
  			}
			$x1 = ($img->getWidth() - IMG_SMALL_WIDTH) / 2;
			$y1 = ($img->getHeight() - IMG_SMALL_HEIGHT) / 3;
			$img->crop($x1, $y1, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT)->saveAs( $ccSmallFile );
						
  	}  	
  }  

}

?>
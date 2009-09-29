<?php

class sfImagePoliticoGD extends sfImageVootaGD
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
	
	$destDir = sfConfig::get('sf_web_dir'). DIRECTORY_SEPARATOR. 'images'.DIRECTORY_SEPARATOR.'politicos';
	
	$ccFile = $destDir . DIRECTORY_SEPARATOR.'cc_'.$this->fileName;
	$bwFile = $destDir . DIRECTORY_SEPARATOR.'bw_'.$this->fileName;
	$ccSmallFile = $destDir . DIRECTORY_SEPARATOR.'cc_s_'.$this->fileName;
	$bwSmallFile = $destDir . DIRECTORY_SEPARATOR.'bw_s_'.$this->fileName;
	
  	if(!file_exists($destDir)) {
  		mkdir($destDir);
  	}

  	if (
  		!file_exists($ccFile) || !file_exists($bwFile) || !file_exists($ccSmallFile) || !file_exists($bwSmallFile)
  		|| filemtime ( $ccFile ) < filemtime( $img->getFilename() )
  		|| filemtime ( $bwFile ) < filemtime( $img->getFilename() )
  		|| filemtime ( $ccSmallFile ) < filemtime( $img->getFilename() )
  		|| filemtime ( $bwSmallFile ) < filemtime( $img->getFilename() )
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
		  	
			$img->greyscale()->saveAs( $bwFile );

			
			$smallImg = new sfImage( $ccFile );
			
			$smallImg->resize($img->getWidth() / 1.5, $img->getHeight() / 1.5);
			$x1 = ($smallImg->getWidth() - IMG_SMALL_WIDTH) / 2;
			$y1 = ($smallImg->getHeight() - IMG_SMALL_HEIGHT) / 3;
			$smallImg->crop($x1, $y1, IMG_SMALL_WIDTH, IMG_SMALL_HEIGHT)->saveAs( $ccSmallFile );
			$smallImg->greyscale()->saveAs( $bwSmallFile );
			
  	}  	
  }  

}

?>
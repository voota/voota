<?php

class sfImageInstitucionGD extends sfImageVootaGD
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
	
	$destDir = sfConfig::get('sf_web_dir'). DIRECTORY_SEPARATOR. 'images'.DIRECTORY_SEPARATOR.'instituciones';
	
	$ccFile = $destDir . DIRECTORY_SEPARATOR.''.$this->fileName;
	
  	if(!file_exists($destDir)) {
  		mkdir($destDir);
  	}

  	if (
  		!file_exists($ccFile) 
  		|| filemtime ( $ccFile ) < filemtime( $img->getFilename() )
  		) {
  			if ($img->getWidth() > IMG_MAX_WIDTH || $img->getHeight() > IMG_MAX_HEIGHT){
  				if ($img->getWidth() > $img->getHeight() * IMG_RATIO) {
  					$img->resize(IMG_MAX_WIDTH, null);
  				}
  				else {
  					$img->resize(null, IMG_MAX_HEIGHT);
  				}
  			}
			$img->saveAs( $ccFile );
			
  	}  	
  }  
  

}

?>
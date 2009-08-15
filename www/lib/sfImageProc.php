<?php
class sfImageVootaGD extends sfImageTransformAbstract
{
	var $directory;
	var $fileName;
	var $bwFile;
	
  // Parameters can be passed in the standard way
  public function __construct($file)
  {
	$this->directory = dirname($file);
	$arr = array_reverse( split("/", $file) );
	$this->fileName = $arr[0];
	$this->bwFile = $this->directory.DIRECTORY_SEPARATOR.'bw_'.$this->fileName;
  }
	
  public function transform(sfImage $img)
  {
  	if(!file_exists($this->bwFile)) {
		$img->greyscale();
		$img->saveAs( $this->bwFile );
  	}
  }  

}

?>
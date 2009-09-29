<?php

abstract class sfImageVootaGD extends sfImageTransformAbstract
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
	

}

?>
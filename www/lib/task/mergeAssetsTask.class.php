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
 * @subpackage utils
 * @author     Sergio Viteri
 */
class mergeAssetsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'backend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'mergeAssets';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [mergeAssets|INFO] task does things.
Call it with:

  [php symfony mergeAssets|INFO]
EOF;
  }
  
  protected function execute($arguments = array(), $options = array())
  {
  	$webDir = sfConfig::get('sf_web_dir');
  	$files = array( 
        "$webDir/js/voota.js",
        //"$webDir/js/ajaxupload.js",
  		"$webDir/sfReviewPlugin/js/sf_review.js",
        "$webDir/sfReviewPlugin/js/jquery.hint.js",
        "$webDir/js/jquery.qtip-1.0.min.js",
        "$webDir/js/bluff/js-class.js",
        "$webDir/js/bluff/excanvas.js",
        "$webDir/js/bluff/bluff.js",
        "$webDir/js/bluff/custom.js"
  	);
  	
  	$out = fopen("$webDir/js/all.js", "w");  
	foreach ($files as $file){
		fwrite($out, implode('', file( "$file" ))."\n");
	}
	fclose( $out );
  }
}

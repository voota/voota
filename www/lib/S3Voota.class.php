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
class S3Voota extends S3 {
	const _BUCKET_ORI = 'sf_s3_bucket_originals';
	const _BUCKET_PUB = 'sf_s3_bucket_public';
	
	public static function getBucketOri(){
		return sfConfig::get(S3Voota::_BUCKET_ORI); 
	}
	public static function getBucketPub(){
		return sfConfig::get(S3Voota::_BUCKET_PUB); 
	}
	
	public function __construct() {
		require_once(sfConfig::get('sf_lib_dir').'/pass.php');
		parent::__construct($s3AccessKey, $s3SecretKey, false);
	}

	public function createPoliticoFromFile( $file ) {
		$directory = dirname($file);
		$arr = array_reverse( split("/", $file) );
		$fileName = $arr[0];
		$uri = "politicos/$fileName";
		
		if (S3::putObject(S3::inputFile("$file"), S3Voota::getBucketOri(), "politicos/$fileName", S3::ACL_PRIVATE)){
			$img = new sfImage( $file );
			$img->politico(  );
			S3::putObject(S3::inputFile("/tmp/cc_$fileName"), S3Voota::getBucketPub(), "politicos/cc_$fileName", S3::ACL_PUBLIC_READ);
			unlink ( "/tmp/cc_$fileName" );
			S3::putObject(S3::inputFile("/tmp/bw_$fileName"), S3Voota::getBucketPub(), "politicos/bw_$fileName", S3::ACL_PUBLIC_READ);
			unlink ( "/tmp/bw_$fileName" );
			S3::putObject(S3::inputFile("/tmp/cc_s_$fileName"), S3Voota::getBucketPub(), "politicos/cc_s_$fileName", S3::ACL_PUBLIC_READ);
			unlink ( "/tmp/cc_s_$fileName" );
			S3::putObject(S3::inputFile("/tmp/bw_s_$fileName"), S3Voota::getBucketPub(), "politicos/bw_s_$fileName", S3::ACL_PUBLIC_READ);
			unlink ( "/tmp/bw_s_$fileName" );
		}
		
	}
	public function createPoliticoFromOri( $fileName ) {
		$uri = "politicos/$fileName";
		if (($info = $this->getObjectInfo(S3Voota::getBucketOri(), $uri)) !== false) {
			$fileOnDisk = "/tmp/$fileName";
			
			if (($object = S3::getObject(S3Voota::getBucketOri(), $uri, "$fileOnDisk")) !== false) {
				$this->createPoliticoFromFile( $fileOnDisk );
				unlink ( "$fileOnDisk" );
			}
		}
	}
	
	public function createInstitucionFromFile( $file ) {
		$directory = dirname($file);
		$arr = array_reverse( split("/", $file) );
		$fileName = $arr[0];
		$uri = "instituciones/$fileName";
		
		if (S3::putObject(S3::inputFile("$file"), S3Voota::getBucketOri(), "instituciones/$fileName", S3::ACL_PRIVATE)){
			$img = new sfImage( $file );
			$img->institucion(  );
			S3::putObject(S3::inputFile("/tmp/cc_$fileName"), S3Voota::getBucketPub(), "instituciones/$fileName", S3::ACL_PUBLIC_READ);
			unlink ( "/tmp/cc_$fileName" );
		}
		
	}
	public function createInstitucionFromOri( $fileName ) {
		$uri = "instituciones/$fileName";
		if (($info = $this->getObjectInfo(S3Voota::getBucketOri(), $uri)) !== false) {
			$fileOnDisk = "/tmp/$fileName";
			
			if (($object = S3::getObject(S3Voota::getBucketOri(), $uri, "$fileOnDisk")) !== false) {
				$this->createInstitucionFromFile( $fileOnDisk );
				unlink ( "$fileOnDisk" );
			}
		}
	}

	public function createUsuarioFromFile( $file ) {
		$directory = dirname($file);
		$arr = array_reverse( split("/", $file) );
		$fileName = $arr[0];
		$uri = "usuarios/$fileName";
		
		$uploaded = $this->upload($file, S3Voota::getBucketOri(), "usuarios/$fileName", S3::ACL_PRIVATE);
		if ( $uploaded ){
			$img = new sfImage( $file );
			$img->usuario(  );
			$uploaded = $this->upload("/tmp/cc_$fileName", S3Voota::getBucketPub(), "usuarios/cc_$fileName", S3::ACL_PUBLIC_READ);
			unlink ( "/tmp/cc_$fileName" );
			if ($uploaded) {
				$uploaded = $this->upload("/tmp/cc_s_$fileName", S3Voota::getBucketPub(), "usuarios/cc_s_$fileName", S3::ACL_PUBLIC_READ);
				unlink ( "/tmp/cc_s_$fileName" );
			}
		}
		
		return $uploaded;
	}
	public function createUsuarioFromOri( $fileName ) {
		$uri = "usuarios/$fileName";
		if (($info = $this->getObjectInfo(S3Voota::getBucketOri(), $uri)) !== false) {
			$fileOnDisk = "/tmp/$fileName";
			
			if (($object = S3::getObject(S3Voota::getBucketOri(), $uri, "$fileOnDisk")) !== false) {
				$this->createUsuarioFromFile( $fileOnDisk );
				unlink ( "$fileOnDisk" );
			}
		}
	}
	
	private function upload($filePath, $bucket, $fileName, $acl) {
		$retries = 3;
		$uploaded = false;
		
		while (!$uploaded && $retries > 0){
			$retries--;
			set_error_handler ( "S3Voota::error_handler" );
			$uploaded = S3::putObject(S3::inputFile($filePath), $bucket, $fileName, $acl);
			restore_error_handler();
		}
		
		return $uploaded;
	}
	
	public static function error_handler($errno, $errstr, $errfile, $errline){
		sfContext::getInstance()->getLogger()->err("S3 error $errno: $errstr");
		
		return true;
	}
}

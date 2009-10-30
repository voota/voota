<?php

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

		parent::__construct($s3AccessKey, $s3SecretKey);
	}

	public function createPoliticoFromFile( $file ) {
		$directory = dirname($file);
		$arr = array_reverse( split("/", $file) );
		$fileName = $arr[0];
		$uri = "politicos/$fileName";
		
		if (S3::putObject(S3::inputFile("$file"), S3Voota::getBucketOri(), "politicos/$fileName", S3::ACL_PRIVATE)){
			$img = new sfImage( $file );
			$img->politico(  );
			unlink ( "$file" );
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
			}
		}
	}
}

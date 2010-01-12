<?php use_helper('Text') ?>

<?php
function formatBio( $str ) {
	//return preg_replace("/\\n/", "<br />", trim($str)==''?'-':$str);
	$str = preg_replace("/\\n/", "\n\n", trim($str)==''?'-':$str);
	return simple_format_text($str);
}

function getDateFromPlain( $str ) {
	return mktime(0, 0, 0, substr($str,4,2), substr($str,6,2), substr($str,0,4));
}

function cutToLength($str, $length = 35) {
	$aText = utf8_decode($str);
	return utf8_encode( strlen($aText) > $length?substr($aText, 0, $length ).".":$aText );
}


function toUrl($str) {
	$ret = $str; 
	if (strpos($str, 'http://') !== 0 ){
		$ret = "http://$str";	
	}
	
	return $ret;
}

function toShownUrl($str) {
	$ret = $str; 
	if (strpos($str, 'http://') === 0 ){
		$ret = substr($str,7);	
	}
	
	if (strlen($ret) > 30){
		$ret = substr($ret, 0, 30) . "...";
	}
	
	return $ret;
}
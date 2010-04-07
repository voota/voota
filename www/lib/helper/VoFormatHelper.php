<?php use_helper('Text') ?>

<?php
function formatDesc( $str ) {
	//return preg_replace("/\\n/", "<br />", trim($str)==''?'-':$str);
	$str = preg_replace("/\\n/", "\n\n", trim($str)==''?'-':$str);
	return simple_format_text($str);
}

function formatBio( $str ){
	return formatDesc( $str );
}

function formatPresentacion( $str ){
	return formatDesc( $str );
}

function getDateFromPlain( $str ) {
	return mktime(0, 0, 0, substr($str,4,2), substr($str,6,2), substr($str,0,4));
}

function cutToLength($str, $length = 35) {
	return SfVoUtil::cutToLength($str, $length);
}



function highlightWords($str, $q) {
	return SfVoUtil::highlightWords($str, $q);
}

function sq($str) {
	$ret = str_replace("'", "\\'", $str);
	
	return $ret;
}

function sumu( $entity ){
  	
  	return $entity->getSumu();
}
function sumd( $entity ){
  	
  	return $entity->getSumd();
}
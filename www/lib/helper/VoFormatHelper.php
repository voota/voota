<?php
function formatBio( $str ) {
	return preg_replace("/\\n/", "<br>", trim($str)==''?'-':$str);
}

function getDateFromPlain( $str ) {
	return mktime(0, 0, 0, substr($str,4,2), substr($str,6,2), substr($str,0,4));
}
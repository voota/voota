<?php
function formatBio( $str ) {
	return preg_replace("/\\n/", "<br>", trim($str)==''?'-':$str);
}
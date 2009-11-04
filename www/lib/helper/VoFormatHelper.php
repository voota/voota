<?php
function formatBio( $str ) {
	return preg_replace("/\\n/", "<br>", $str);
}
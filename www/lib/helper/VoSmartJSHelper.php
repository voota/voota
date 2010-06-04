<?php
function jsWrite( $name, $attrs = array() ){
	if ( !isset($GLOBALS["jsw_id"]) ){
		$GLOBALS["jsw_id"] = 1;
	}
	$id = $GLOBALS["jsw_id"]++;
	
	$ret = "<span id=\"jsw_$id\"></span>";
	$ret .= "<script type=\"text/javascript\" charset=\"utf-8\">";
	$ret .= "var aTag = document.createElement(\"$name\");";
	foreach($attrs as $name => $value){
		$ret .= " aTag.setAttribute('$name', '$value');";
	}	  
	$ret .= "$('#jsw_$id').append(aTag);";
	$ret .= "</script>";
	
	return $ret;
}
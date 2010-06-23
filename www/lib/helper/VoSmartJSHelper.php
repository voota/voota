<?php
function jsWrite( $name, $attrs = array(), $content = NULL ){
	if ( !isset($GLOBALS["jsw_id"]) ){
		$GLOBALS["jsw_id"] = rand();
	}
	$id = $GLOBALS["jsw_id"]++;
	
	$ret = "<span id=\"jsw_$id\"></span>";
	$ret .= "<script type=\"text/javascript\" charset=\"utf-8\">";
	$ret .= "var aTag = document.createElement(\"$name\");";
	foreach($attrs as $name => $value){
		$ret .= " aTag.setAttribute('$name', '$value');";
	}
	if ($content) {
	  $ret .= " aTag.innerHTML = '$content';";
	}
	$ret .= "$('#jsw_$id').append(aTag);";
	$ret .= "</script>";
	
  return "$ret";
}
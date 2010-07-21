<?php use_helper('Text') ?>

<?php

function armorTag($str) {
	return str_replace(".", "_2E_", $str);
}

function v_simple_format_text($text, $options = array(), $ender = "")
{
  $css = (isset($options['class'])) ? ' class="'.$options['class'].'"' : '';

  $text = sfToolkit::pregtr($text, array("/(\r\n|\r)/"        => "\n",               // lets make them newlines crossplatform
                                         "/\n{2,}/"           => "</p><p$css>"));    // turn two and more newlines into paragraph

  // turn single newline into <br/>
  $text = str_replace("\n", "\n<br />", $text);
  return '<p'.$css.'>'.$text.$ender.'</p>'; // wrap the first and last line in paragraphs before we're done
}

function formatDesc( $str, $ender = "" ) {
	//return preg_replace("/\\n/", "<br />", trim($str)==''?'-':$str);
	$str = preg_replace("/\\n/", "\n\n", trim($str)==''?'-':$str);
	return v_simple_format_text($str, array(), $ender);
}

function formatBio( $str ){
	return formatDesc( $str );
}

function formatPresentacion( $str, $ender = "" ){
	return formatDesc( $str, $ender );
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

function ByteSize($bytes) {
    $size = $bytes / 1024;
    if($size < 1024){
        $size = format_number( number_format($size, 2), 'es_ES' );
        $size .= ' KB';
    } 
    else {
        if($size / 1024 < 1024) 
            {
            $size = format_number( number_format($size / 1024, 2), 'es_ES' );
            $size .= ' MB';
            } 
        else if ($size / 1024 / 1024 < 1024)  
            {
            $size = format_number( number_format($size / 1024 / 1024, 2), 'es_ES' );
            $size .= ' GB';
            } 
    }
    
    return $size;
}

function secureString( $str ){
	$ret = str_replace( '\'', '&#146;',  $str);
	$ret = str_replace( '"', '&quot;',  $ret);
	
	return $ret;
}

  function getLinks($lastPage, $page, $nb_links = 5)
  {
    $links = array();
    $tmp   = $page - floor($nb_links / 2);
    $check = $lastPage - $nb_links + 1;
    $limit = ($check > 0) ? $check : 1;
    $begin = ($tmp > 0) ? (($tmp > $limit) ? $limit : $tmp) : 1;
 
    $i = $begin;
    while (($i < $begin + $nb_links) && ($i <= $lastPage))
    {
      $links[] = $i++;
    }
 
    //$this->currentMaxLink = $links[count($links) - 1];
 
    return $links;
  } 
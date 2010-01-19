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
class SfVoUtil
{
	const VANITY_MIN_LENGTH = 3;
	const SHORT_INSTITUCIONES_NUM = 7;
	const URL_FILLER = "-";
	const HIGHLIGHT_LENGTH = 50;
	
	public static function encodeVanity( $str ) {
		$ret = str_replace(" ", "-", $str);
		
		while (strlen( $ret ) < SfVoUtil::VANITY_MIN_LENGTH){
			$ret .= SfVoUtil::URL_FILLER;
		}
    	return $ret;
	}

	public static function stripAccents($str){
		$ret = utf8_encode(SfVoUtil::voDecode($str));

		return $ret;
	}
	
	public static function voDecode( $str ){
		return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}
	
	public static function highlightWords($string, $q)
	{
		$words = explode(' ', $q);
		
	 	$aString =  $string;
	 	$pos = -1;
	 	$pos1 = false;
	    foreach ( $words as $idx => $word )
	    {
	    	$pos = stripos(SfVoUtil::voDecode($aString), SfVoUtil::voDecode($word));
	    	if ($idx == 0 && $pos !== FALSE){
	    		$pos1 = $pos;
	    		$aString = substr  ($aString, ($pos-SfVoUtil::HIGHLIGHT_LENGTH >= 0)?($pos-SfVoUtil::HIGHLIGHT_LENGTH):0, SfVoUtil::HIGHLIGHT_LENGTH*2);
	    		$pos = stripos(SfVoUtil::voDecode($aString), SfVoUtil::voDecode($word));
	    	}
	    	if ($pos !== FALSE){
	        	$aString = utf8_encode( substr(utf8_decode($aString), 0, $pos)
	        		. '<span class="highlight_word">'
	        		. substr (utf8_decode($aString), $pos, strlen(utf8_decode($word)))
	        		. '</span>'
	        		. substr (utf8_decode($aString), $pos + strlen(utf8_decode($word))) );
	       	}
	    }
	    
	    $endCut = $pos1 && strlen( substr($aString, ($pos1-SfVoUtil::HIGHLIGHT_LENGTH >= 0)?($pos1-SfVoUtil::HIGHLIGHT_LENGTH):0) ) < strlen(utf8_decode($string));
	    return (($pos1?$pos1:0)-SfVoUtil::HIGHLIGHT_LENGTH >= 0?'[...] ':'') . $aString . ($endCut?' [...]':'')  ;
	}
	
	public static function matches($str1, $q, $or = false)
	{
		$words = explode(' ', $q);
		
		$ret = false;
		if (count($words) > 0 && !$or){
			$ret = true;
		}
	    foreach ( $words as $idx => $word ){
	    	$isTrue = stripos(SfVoUtil::stripAccents($str1), SfVoUtil::stripAccents($word)) !== FALSE;
	    	if ($or) {
	    		$ret = $ret || $isTrue; 
	    	}
	    	else {
	    		$ret = $ret && $isTrue; 
	    	}
	    }
		return $ret;
	}
}
 
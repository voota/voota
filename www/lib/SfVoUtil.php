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
	const ACCENTS = 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
	const ACCENT_REPLACEMENTS = 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';
	const UPPER_ACCENTS = 'ÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
	const LOWER_ACCENTS  = 'àáâãäçèéêëìíîïñòóôõöùúûüý';
	
	public static function encodeVanity( $str ) {
		$ret = str_replace(" ", self::URL_FILLER, trim($str));
		$ret = self::fixVanityChars( $ret );
		
		while (strlen( $ret ) < SfVoUtil::VANITY_MIN_LENGTH){
			$ret .= self::URL_FILLER;
		}
    	return $ret;
	}

	public static function stripAccents($str){
		$ret = utf8_encode(SfVoUtil::voDecode($str));

		return $ret;
	}
	
	public static function voDecode( $str ){
		return strtr(utf8_decode($str), utf8_decode(self::ACCENTS), self::ACCENT_REPLACEMENTS);
	}

	public static function highlightWords($string, $q)
	{
		$words = explode(' ', trim($q));
		
	 	$expw = '';
	    foreach ( $words as $idx => $word ){
	    	$expw .= ($idx==0?'':'|'). self::voDecode($word); 
	    }

	    $initString = $string;
	    
    	$aWord = SfVoUtil::voDecode($word);
    	$exp = "/[a-z0-9".self::ACCENTS."]*.{0,".self::HIGHLIGHT_LENGTH."}($expw).{0,".self::HIGHLIGHT_LENGTH."}[a-z0-9".self::ACCENTS."]*/is";
    	if (preg_match($exp, SfVoUtil::voDecode($string), $matches, PREG_OFFSET_CAPTURE)) {
    		$shorStr = $matches[0][0];
    		$iniPos = strpos(SfVoUtil::voDecode($string), $shorStr);
    		$shortLen = strlen($shorStr);
    	}
    	else {
    		$iniPos = 0;
    		$shortLen = self::HIGHLIGHT_LENGTH*2;
    	}
    	$initString = ($iniPos > 0?'...':'') .utf8_encode( substr(utf8_decode($string), $iniPos, $shortLen). ($shortLen < strlen(utf8_decode($string))?'...':'') );
    	$aString = $initString;
    	
    	if (preg_match_all("/$expw/is", SfVoUtil::voDecode($initString), $matches, PREG_OFFSET_CAPTURE)){
    		$aString = "";
    		foreach($matches[0] as $idx => $match){
    			$initPos = $idx == 0?0:($match[1]);
    			$endPos = isset($matches[0][$idx+1])?($matches[0][$idx+1][1] - $match[1] - strlen($match[0])):strlen(utf8_decode($initString))-$match[1];
	        	$aString .= ($idx == 0?substr(utf8_decode($initString), $initPos, $match[1]):'')
	        		. '<span class="highlight_word">'
	        		. substr (utf8_decode($initString), $match[1], strlen($match[0]))
	        		. '</span>'
	        		. substr (utf8_decode($initString), $match[1] + strlen($match[0]), $endPos) 
	        		;
    		}
    		$aString = utf8_encode($aString);
    	}
	    	
	    return $aString;
	}
		
	public static function matches($string, $q, $or = false)
	{
		$words = explode(' ', $q);
		
		$ret = true;
		if ($or){
			$ret = false;
		}
	    foreach ( $words as $idx => $word ) {
	    	if ($or){
		    	$ret = $ret || preg_match("/".self::voDecode($word)."/i", self::voDecode($string));  
	    	}
	    	else{
		    	$ret = $ret && preg_match("/".self::voDecode($word)."/i", self::voDecode($string));  
	    	}
	    }
	    
		return $ret;
	}
	
	public static function cutToLength($str, $length = 35, $ext = '...', $fullWords = false) {
		$ret = '';
		$aStr = preg_replace("/\n/is", " ", $str);
		
		$strLength = strlen(utf8_decode($aStr));
		
		if ($strLength > $length){
			$exp = "/.{".$length."}".($fullWords?("[a-z0-9".self::ACCENTS."]*"):'')."/is";
			if (preg_match($exp, $aStr, $matches, PREG_OFFSET_CAPTURE)) {
				$newStr = $matches[0][0]; 
				$ret = "$newStr";
			};
		}
		else {
			$ret = $aStr;
		}
		
		return $ret. ($strLength > strlen(utf8_decode($ret))?$ext:'');
	}
	
	public static function isEmail($email) {
    	return preg_match('|^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$|i', $email);
	}

	public static function isCanonicalVootaUser( $user ) {
		return $user 
				&& $user->getProfile()->getNombre()
				&& $user->getProfile()->getNombre() != ''
				&& SfVoUtil::isEmail( $user->getUsername() )
				;
	}	
	
	public static function fixVanityChars( $v ) {
		return strtr($v, '.$&+,/:;=?@ "<>#%{}|\^~[]`', '--------------------------');
	}
	
	public static function myUcfirst( $str) {
		$ret = utf8_encode(
			strtoupper(strtr(substr(utf8_decode($str), 0, 1), utf8_decode(self::LOWER_ACCENTS), utf8_decode(self::UPPER_ACCENTS)))
			. strtolower(strtr(substr(utf8_decode($str),1), utf8_decode(self::UPPER_ACCENTS), utf8_decode(self::LOWER_ACCENTS)))
			);
			
		return $ret;
	}
	
	public static function changeD( $str) {
		if (strtolower(substr(utf8_decode($str), 0, 2)) == "d'"){
			return "d'" . self::myUcfirst(utf8_encode(substr(utf8_decode($str),2)));
		}
		else {
			return $str;
		}
	}
	
	public static function fixCase( $str, $sep = " " ){
		$NAME_EXCLUDES = array("de", "del", "la", "las", "el", "los", "i", "y", "do");
		$ret = "";
		
		$words = explode($sep, $str);
		foreach ($words as $word){
			if ($sep == " "){
				$newWord = self::fixCase($word, "-");
			}
			else{
				if (! in_array(strtolower($word), $NAME_EXCLUDES)){
					$newWord = self::myUcfirst($word);
				}
				else {
					$newWord = strtolower($word);
				}
			}
			$ret .= ($ret?$sep:'') . self::changeD($newWord);
		}
		
		return $ret;
	}
	
	public static function secureString( $str, $rep = '\\\'' ){
		return str_replace( '\'', $rep,  $str);
	}
	
	public static function reviewPermalink( $review, $culture = false ){
		$userCulture = $culture?$culture:sfContext::getInstance()->getUser()->getCulture();		
		
		$textStart = (!$review->getCulture() || $review->getCulture() == $userCulture)?self::fixVanityChars(self::cutToLength($review->getText(), 60, '', true)):'';
		return ''.$review->getId(). ($textStart?'-':''). $textStart;
	}
}
 



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
	
	public static function encodeVanity( $str ) {
		$ret = str_replace(" ", "-", $str);
		
		while (strlen( $ret ) < SfVoUtil::VANITY_MIN_LENGTH){
			$ret .= SfVoUtil::URL_FILLER;
		}
    	return $ret;
	}

	public static function stripAccents($str){
		$ret = utf8_encode(strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'));

		return $ret;
	}
}
 
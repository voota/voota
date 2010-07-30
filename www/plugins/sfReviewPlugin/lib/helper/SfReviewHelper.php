<?php


function review_text($review, $msg = array(), $allCultures = false){
	$routes = sfContext::getInstance()->getRouting()->getRoutes ();

	if (array_key_exists('rules', $routes)){
		$msg = array(
			'offensive' => sfContext::getInstance()->getI18N()->__("Opinión tachada por el moderador (<a href='%1%'>ver normas de publicación</a>)."
				, array('%1%' => sfContext::getInstance()->getRouting()->generate('rules'))),
			'deleted' => sfContext::getInstance()->getI18N()->__("Opinión eliminada por el moderador (<a href='%1%'>ver normas de publicación</a>)."
				, array('%1%' => sfContext::getInstance()->getRouting()->generate('rules'))),
		);
	}
	else {
		$msg = array(
			'offensive' => sfContext::getInstance()->getI18N()->__("Opinión tachada por el moderador."),
			'deleted' => sfContext::getInstance()->getI18N()->__("Opinión eliminada por el moderador."),
		);
	}
	
	$doShowText = $allCultures || ($review->getCulture() == '' || $review->getCulture() == sfContext::getInstance()->getUser()->getCulture());
	$text = $doShowText?$review->getText():'';
		
	if ($review->getSfReviewStatus()->getPublished() == 1){
		if ($review->getSfReviewStatus()->getOffensive() == 0){
			autolink( $text );
			$ret = $text;
		}
		else {
			$ret = "<span style='text-decoration: line-through;'>". utf8_strrev( $text ) ."</span>";
			$ret .= "<br />". $msg['offensive'];
		}
	}
	else {
		$ret = "<br />". $msg['deleted'] ."";
	}
	return $ret;
}

function utf8_strrev($str){
    preg_match_all('/./us', $str, $ar);
    return join('',array_reverse($ar[0]));
}

function review_date_diff( $date ){
	$d1 = time();
	$d2 = strtotime($date);
	return floor(($d1 - $d2)/(60*60*24*365));
}

function getAutolink($text, $nofollow=false) {
	$value = $text;
	autolink($text, $nofollow);
	
	return $text;
}
//function autolink( &$text, $target='_blank', $nofollow=true )
function autolink( &$text, $nofollow=false )
{
  // grab anything that looks like a URL...
  $urls  =  _autolink_find_URLS( $text );
  if( !empty($urls) ) // i.e. there were some URLS found in the text
  {
    //array_walk( $urls, '_autolink_create_html_tags', array('target'=>$target, 'nofollow'=>$nofollow) );
    array_walk( $urls, '_autolink_create_html_tags', array('nofollow'=>$nofollow) );
    $text  =  strtr( $text, $urls );
  }
}

function _autolink_find_URLS( $text )
{
  // build the patterns
  $scheme         =       '(http:\/\/|https:\/\/)';
  $www            =       'www\.';
  $ip             =       '\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}';
  $subdomain      =       '[-a-z0-9_]+\.';
  $name           =       '[a-z][-a-z0-9]+\.';
  $tld            =       '[a-z]+(\.[a-z]{2,2})?';
  $the_rest       =       '\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}';            
  //$pattern        =       "$scheme?(?(1)($ip|($subdomain)?$name$tld)|($www$name$tld))$the_rest";
  $pattern        =       "$scheme?(?(1)($ip|($subdomain)?$tld)|($www$name$tld))$the_rest";
  
  $pattern        =       '/'.$pattern.'/is';
  $c              =       preg_match_all( $pattern, $text, $m );
  unset( $text, $scheme, $www, $ip, $subdomain, $name, $tld, $the_rest, $pattern );
  if( $c )
  {
    return( array_flip($m[0]) );
  }
  return( array() );
}

function toUrl($str) {
	$aStr = trim( $str );
	
	$ret = $aStr; 
	if (strpos($aStr, 'http://') !== 0 ){
		$ret = "http://$aStr";	
	}
	
	return $ret;
}

function toShownUrl($str) {
	$aStr = trim( $str );
	
	$ret = $aStr; 
	if (strpos($aStr, 'http://') === 0 ){
		$ret = substr($aStr,7);	
	}
	
	if (strlen($ret) > 30){
		$ret = sfVoUtil::cutToLength($ret, 30);
	}
	
	return $ret;
}

function _autolink_create_html_tags( &$value, $key, $other=null )
{
  $target = $nofollow = null;
  if( is_array($other) )
  {
    //$target      =  ( $other['target']   ? " target=\"$other[target]\"" : null );
    // see: http://www.google.com/googleblog/2005/01/preventing-comment-spam.html
    $nofollow    =  ( $other['nofollow'] ? ' rel="nofollow"'            : null );     
  }
  $value = "<a href=\"".toUrl($key)."\"$target$nofollow>".toShownUrl($key)."</a>";
} 

function format_plural($count, $singular, $plural, $args = array(), $langcode = NULL) {
  $args['@count'] = $count;
  if ($count == 1) {
    return t($singular, $args, $langcode);
  }

  // Get the plural index through the gettext formula.
  $index = (function_exists('locale_get_plural')) ? locale_get_plural($count, $langcode) : -1;
  // Backwards compatibility.
  if ($index < 0) {
    return t($plural, $args, $langcode);
  }
  else {
    switch ($index) {
      case "0":
        return t($singular, $args, $langcode);
      case "1":
        return t($plural, $args, $langcode);
      default:
        unset($args['@count']);
        $args['@count['. $index .']'] = $count;
        return t(strtr($plural, array('@count' => '@count['. $index .']')), $args, $langcode);
    }
  }
}

function ago($timestamp, $aprox = true){
	if (!$timestamp){
		return '';
	}
   $difference = time() - $timestamp;
   $periods = array(
   				sfContext::getInstance()->getI18N()->__("segundo"),
   				sfContext::getInstance()->getI18N()->__("minuto"),
   				sfContext::getInstance()->getI18N()->__("hora"),
   				sfContext::getInstance()->getI18N()->__("día"),
   				sfContext::getInstance()->getI18N()->__("semana"),
   				sfContext::getInstance()->getI18N()->__("mes"),
   				sfContext::getInstance()->getI18N()->__("año"),
   				sfContext::getInstance()->getI18N()->__("década")
   );
   $periods_plural = array(
   				sfContext::getInstance()->getI18N()->__("segundos"),
   				sfContext::getInstance()->getI18N()->__("minutos"),
   				sfContext::getInstance()->getI18N()->__("horas"),
   				sfContext::getInstance()->getI18N()->__("días"),
   				sfContext::getInstance()->getI18N()->__("semanas"),
   				sfContext::getInstance()->getI18N()->__("meses"),
   				sfContext::getInstance()->getI18N()->__("años"),
   				sfContext::getInstance()->getI18N()->__("décadas")
   );
   if ($aprox && $difference < (60 * 30)){
   	   $difference = sfContext::getInstance()->getI18N()->__("un");
	   $aPeriod = sfContext::getInstance()->getI18N()->__("ratito");
   }
   else {
	   $lengths = array("60","60","24","7","4.35","12","10");
	   for($j = 0; $difference >= $lengths[$j]; $j++){
	   		$difference /= $lengths[$j];
	   }
	   $difference = round($difference);
	   if($difference != 1){
	   		$aPeriod = $periods_plural[$j];
	   }
	   else {
	   		$aPeriod = $periods[$j];
	   }
   }
   $text = sfContext::getInstance()->getI18N()->__("Hace %1% %2%", array('%1%' => $difference, '%2%' => $aPeriod));
   return $text;
}

function fbCheckbox($reviewBox, $reviewToFb, $reviewId, $reviewType, $sf_user){
	$fb_checked = false;
	if ($reviewId != '') {
		$fb_checked = $reviewToFb;
	}
	elseif ($sf_user->getProfile()->getFacebookUid()){
		if (($sf_user->getProfile()->getFbPublishVotos() && $reviewType)
				|| ($sf_user->getProfile()->getFbPublishVotosOtros() && !$reviewType)){
			$fb_checked = true;
		}
	}
      		
      		
	return "<input type=\"checkbox\" name=\"fb_publish\" value=\"1\" id=\sf-review-fb-publish-$reviewBox\"" . ($fb_checked?' checked="checked"' : '')." />";
}

function twCheckbox($reviewBox, $reviewToTw, $reviewId, $reviewType, $sf_user){
	$tw_checked = false;
	if ($reviewId != '') {
		$tw_checked = $reviewToTw;
	}
	elseif ($sf_user->getProfile()->getFacebookUid()){
		if (($sf_user->getProfile()->getTwPublishVotos() && $reviewType)
				|| ($sf_user->getProfile()->getTwPublishVotosOtros() && !$reviewType)){
			$tw_checked = true;
		}
	}
      		
      		
	return "<input type=\"checkbox\" name=\"tw_publish\" value=\"1\" id=\sf-review-tw-publish-$reviewBox\"" . ($tw_checked?' checked="checked"' : '')." />";
}


function anonCheckbox($reviewBox, $anonReview, $reviewId, $sf_user){
	$anon_checked = false;
	if ($reviewId != '') {
			$anon_checked = $anonReview;
	}
	else {
		$anon_checked = $sf_user->getProfile()->getAnonymous();
	}
      		      		
	return "<input type=\"checkbox\" name=\"anon_publish\" value=\"1\" id=\"sf-review-anon-publish-$reviewBox\"" . ($anon_checked?' checked="checked"' : '')." />";
}
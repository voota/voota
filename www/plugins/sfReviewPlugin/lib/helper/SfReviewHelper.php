<?php


function review_text($review, $msg = array()){
	$msg = array(
		'offensive' => sfContext::getInstance()->getI18N()->__("Opinión tachada por el moderador."),
		'deleted' => sfContext::getInstance()->getI18N()->__("Opinión eliminada por el moderador."),
	);
		
	if ($review->getSfReviewStatus()->getPublished() == 1){
		if ($review->getSfReviewStatus()->getOffensive() == 0){
			$ret = $review->getText();
		}
		else {
			$ret = "<span style='text-decoration: line-through;'>". utf8_strrev( $review->getText() ) ."<span>";
			$ret .= "<p>". $msg['offensive'] ."</p>";
		}
	}
	else {
		$ret = "<p>". $msg['deleted'] ."</p>";
	}
	return $ret;
}

function utf8_strrev($str){
    preg_match_all('/./us', $str, $ar);
    return join('',array_reverse($ar[0]));
}
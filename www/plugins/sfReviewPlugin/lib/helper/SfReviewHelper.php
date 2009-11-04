<?php

function review_text($review, $options = array()){
	if ($review->getSfReviewStatus()->getPublished()){
		if (!$review->getSfReviewStatus()->getOffensive()){
			return $review->getText();
		}
		else {
			return "<span style='text-decoration: line-through;'>". utf8_strrev( $review->getText() ) ."<span>";
		}
	}
}

function utf8_strrev($str){
    preg_match_all('/./us', $str, $ar);
    return join('',array_reverse($ar[0]));
}
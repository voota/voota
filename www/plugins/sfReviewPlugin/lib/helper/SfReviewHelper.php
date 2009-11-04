<?php

function review_text($review, $options = array()){
	if ($review->getSfReviewStatus()->getPublished()){
		if (!$review->getSfReviewStatus()->getOffensive()){
			return $review->getText();
		}
		else {
			return "<span style='text-decoration: line-through;'>". strrev( $review->getText() ) ."<span>";
		}
	}
}
<?php include_partial('sfr_form', array(
	'reviewId' => $reviewId,
	'reviewEntityId' => $reviewEntityId,
	'reviewType' => $reviewType,
	'reviewBox' => $reviewBox,
	'redirect' => $redirect,
	'reviewValue' => $reviewValue,
	'reviewText' => $reviewText,
	'reviewToFb' => $reviewId?$reviewToFb:false,
	'reviewToTw' => $reviewId?$reviewToTw:false,
	'anonReview' => $reviewId?$anonReview:false,
	'cf' => isset($cf)?$cf:false
)); ?>

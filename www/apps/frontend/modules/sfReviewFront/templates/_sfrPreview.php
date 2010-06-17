<?php if($reviewId):?>
	<?php include_partial('sfReviewFront/preview', array(
		'reviewBox' => $reviewBox, 
		'reviewType' => $reviewType, 
		'reviewEntityId' => $reviewEntityId,
		'reviewValue' => $reviewValue,
		'review' => $review
	)) ?>
<?php else: ?>
	<?php include_partial(
		'sfReviewFront/init', array('reviewBox' => $reviewBox, 
		'reviewTypeId' => $reviewType, 
		'reviewEntityId' => $reviewEntityId
	)) ?>
<?php endif ?>
			
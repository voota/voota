<?php 
include_partial('editFBSuccess', 
		array(
			'profileEditForm' => $sf_user->isAuthenticated()?$profileEditForm:null
			, 'lastReview' => $sf_user->isAuthenticated()?$lastReview:null
			, 'lastReviewOnReview' => $sf_user->isAuthenticated()?$lastReviewOnReview:null
		)
) ?>
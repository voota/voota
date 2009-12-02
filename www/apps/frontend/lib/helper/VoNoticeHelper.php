<?php
function showNotices( $user ) {
	$flashType = $user->getFlash('notice_type');
	if (!$flashType || $flashType == ''){
		$flashType = "notice";
	}
	if ($user->hasFlash('notice')) {
		echo "<p class='$flashType'>". $user->getFlash('notice') ."</p>";
	}
}
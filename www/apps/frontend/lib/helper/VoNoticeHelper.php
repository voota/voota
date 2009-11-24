<?php
function showNotices( $user ) {
	$flashType = $user->getFlash('notice_type');
	if (!$flashType || $flashType == ''){
		$flashType = "notice";
	}
	if ($user->hasFlash('notice')) {
		echo "<div class='$flashType'><h5 class='$flashType'>". $user->getFlash('notice') ."</h5></div>";
	}
}
<?php foreach($reviewsPager->getResults() as $review): ?>
	<?php include_component_slot('review_for_list', array('review' => $review)) ?>
<?php endforeach ?>

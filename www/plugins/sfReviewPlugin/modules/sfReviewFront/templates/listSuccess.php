<ol>
<?php foreach ($reviewList->getResults() as $review):?>
	<ul><?php include_partial('review', array('review' => $review, 'reviewable' => false)) ?></ul>
<?php endforeach ?>
</ol>
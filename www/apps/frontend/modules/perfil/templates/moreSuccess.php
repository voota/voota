<?php foreach ($reviews->getResults() as $review): ?>
	<?php include_component_slot('profileReview', array('review' => $review)) ?>
<?php endforeach ?>

<?php if ($reviews->haveToPaginate() && $reviews->getLastPage() <= $reviews->getPage()): ?>
  <script type="text/javascript" charset="utf-8">
    $('#more_reviews').hide();
  </script>
<?php endif ?>
<p class="subreviews-summary">
  <?php if( count($review->getSfReviewsRelatedBySfReviewId($uc)) > 0 || count($review->getSfReviewsRelatedBySfReviewId($dc)) > 0 ): ?>
	  (<?php echo __('Lleva') ?>
	  <?php if( count($review->getSfReviewsRelatedBySfReviewId($uc)) > 0  ): ?>
		  <?php echo count($review->getSfReviewsRelatedBySfReviewId($uc)) ?>
		  <?php echo __('a favor') ?>
    <?php endif ?>
    <?php if( count($review->getSfReviewsRelatedBySfReviewId($uc)) > 0 && count($review->getSfReviewsRelatedBySfReviewId($dc)) > 0 ): ?>
	    <?php echo __('y') ?>
    <?php endif ?>
	  <?php if( count($review->getSfReviewsRelatedBySfReviewId($dc)) > 0  ): ?>
		  <?php echo count($review->getSfReviewsRelatedBySfReviewId($dc)) ?>
      <?php echo __('en contra') ?>
    <?php endif ?>,
    <a href="#" onclick="$('#<?php echo "sf_review_sr_c${listValue}_".$review->getId() ?>').slideDown();return false;"><?php echo __('ver') ?></a>)
  <?php else: ?>
    (<?php echo __('de momento no tiene') ?>)
	<?php endif ?>
</p>
<div style="display: none" id="<?php echo "sf_review_sr_c${listValue}_".$review->getId() ?>" ><?php include_component_slot('subreviews', array('id' => $review->getId(), 'listValue' => $listValue)) ?></div>
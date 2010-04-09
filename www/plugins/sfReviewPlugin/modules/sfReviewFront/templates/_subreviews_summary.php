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
    <span id="<?php echo "ver_sr_c${listValue}_".$review->getId() ?>"><a href="#" onclick="$('#<?php echo "sf_review_sr_c${listValue}_".$review->getId() ?>').slideDown();$('#<?php echo "ver_sr_c${listValue}_".$review->getId() ?>').hide();$('#<?php echo "ocultar_sr_c${listValue}_".$review->getId() ?>').show();return false;"><?php echo __('ver') ?></a></span><span style="display:none" id="<?php echo "ocultar_sr_c${listValue}_".$review->getId() ?>"><a href="#" onclick="$('#<?php echo "sf_review_sr_c${listValue}_".$review->getId() ?>').slideUp();$('#<?php echo "ver_sr_c${listValue}_".$review->getId() ?>').show();$('#<?php echo "ocultar_sr_c${listValue}_".$review->getId() ?>').hide();return false;"><?php echo __('ocultar') ?></a></span>)
  <?php endif ?>
</p>
<div <?php if(sfContext::getInstance()->getUser()->getAttribute('sfr_lastvoted_review_id', '') != $review->getId()):?>style="display: none" <?php endif?>class="subreviews-wrapper" id="<?php echo "sf_review_sr_c${listValue}_".$review->getId() ?>" ><?php include_component_slot('subreviews', array('id' => $review->getId(), 'listValue' => $listValue)) ?></div>
<?php use_helper('VoUser'); ?>

<div class="review-avatar">
  <?php if(!$review->getAnonymous()): ?>
    <?php echo getAvatar( $review->getsfGuardUser() ) ?>
  <?php else: ?>
  	<?php echo image_tag(S3Voota::getImagesUrl().'/usuarios/v.png', array('alt' => __('Vooto anónimo (está en su derecho)'), 'width' => 36, 'height' => 36)); ?>
  <?php endif ?>
</div>
<h4 class="review-name">
  <?php if(!$review->getAnonymous()): ?>
	  <?php echo link_to(fullName( $review->getsfGuardUser() ), '@usuario?username='.$review->getsfGuardUser()->getProfile()->getVanity())?>
	  <?php echo party( $review->getsfGuardUser() ) ?>
	  <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
	    <span class="review-years">· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?></span>
	  <?php endif ?>
  <?php else: ?>
  	<?php echo __('Vooto anónimo') ?> <?php echo __('(está en su derecho)')?>
  <?php endif ?>
  
  
	<?php if ($review->getValue() == -1): ?>
		<?php echo ' · '  . __('en contra'); ?>
	<?php endif ?>
	<?php if ($review->getValue() == 1): ?>
		<?php echo ' · '  . __('a favor'); ?>
	<?php endif ?>
</h4>
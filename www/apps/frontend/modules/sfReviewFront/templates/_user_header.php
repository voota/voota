<?php use_helper('VoUser'); ?>

<div class="review-avatar">
  <?php echo getAvatar( $review->getsfGuardUser() ) ?>
</div>
<h4 class="review-name">
  <?php echo link_to(fullName( $review->getsfGuardUser() ), '@usuario?username='.$review->getsfGuardUser()->getProfile()->getVanity())?>
  <?php echo party( $review->getsfGuardUser() ) ?>
  <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
    <span class="review-years">· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?></span>
  <?php endif ?>
	<?php if ($review->getValue() == -1): ?>
		<?php echo ' · ' . image_tag('icoMiniDown.png', 'alt="buu"') . ' ' . __('en contra'); ?>
	<?php endif ?>
	<?php if ($review->getValue() == 1): ?>
		<?php echo ' · ' . image_tag('icoMiniUp.png', 'alt="yeah"') . ' ' . __('a favor'); ?>
	<?php endif ?>
</h4>
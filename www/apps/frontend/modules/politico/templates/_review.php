<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php $reviewable = isset($reviewable)?$reviewable:false ?>

<li class="review">
	<div class="review-avatar">
    <?php if( $review->getsfGuardUser()->getProfile()->getImagen() ): ?>
      <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.( $review->getsfGuardUser()->getProfile()->getImagen()), array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
    <?php else: ?>
      <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/v.png', array('alt' => $review->getsfGuardUser()->getProfile()->getNombre().' ' .  $review->getsfGuardUser()->getProfile()->getApellidos(), 'width' => 36, 'height' => 36)) ?>
    <?php endif ?>
	</div>
  <h4 class="review-name">
    <?php echo $review->getsfGuardUser()->getProfile()->getNombre(); ?> <?php echo $review->getsfGuardUser()->getProfile()->getApellidos(); ?>
    <?php if( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() ): ?>
      <span class="review-years">· <?php echo __('%1% años', array('%1%' => review_date_diff( $review->getsfGuardUser()->getProfile()->getFechaNacimiento() )))?></span>
    <?php endif ?>
  </h4>
	<p class="review-date">
	  <?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?>
	</p>
  <p class="review-body">
    <?php echo review_text( $review ) ?>
  </p>
  <p class="review-actions">
   <a href="#" onclick="return loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $review->getId() ?>,  0, '<?php echo "sf_review_c".$review->getId() ?>' )"><?php echo _('Opinar sobre este comentario')?></a> (Lleva 1 <img alt="a favor" src="/images/icoMiniUp.png" />)
  </p>
  <div id="<?php echo "sf_review_c".$review->getId() ?>" ></div>
  
<?php if ($reviewable && count($review->getSfReviewsRelatedBySfReviewId()) > 0): ?>
	<?php include_component_slot('subreviews', array('id' => $review->getId())) ?>
<?php endif ?>
</li>
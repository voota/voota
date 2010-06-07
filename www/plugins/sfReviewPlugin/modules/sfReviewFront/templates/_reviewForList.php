<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoUser'); ?>
<?php use_helper('VoSmartJS'); ?>

<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $uc->add(SfReviewPeer::IS_ACTIVE, true); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1); $dc->add(SfReviewPeer::IS_ACTIVE, true);  ?>
<?php $listValue = isset($listValue)?$listValue:''?>

<li class="review" id="<?php echo "sf_review_c_m".$review->getId() ?>">
  <div class="review-avatar">
    <?php echo getAvatar( $review->getsfGuardUser(), 19, 19 ) ?>
  </div>
  <div class="review-name">
  	<a title='<?php echo $review->getsfGuardUser() ?>' href="<?php echo url_for('@usuario?username='.$review->getsfGuardUser()->getProfile()->getVanity())?>"><?php echo fullName( $review->getsfGuardUser(), 15 ) ?></a>
    <?php if ($review->getValue() == -1): ?>
  		<?php echo __('voota en contra de') ?>
  	<?php endif ?>
  	<?php if ($review->getValue() == 1): ?>
  		<?php echo __('voota a favor de') ?>
  	<?php endif ?>
    <?php echo $aReview?__('otro comentario sobre ') ." ":'' ?><a title='<?php echo sfVoUtil::secureString($entity, "&#39;") ?>' href="<?php echo url_for($entity->getModule().'/show?id='.$entity->getVanity())?>"><?php echo sfVoUtil::cutToLength(sfVoUtil::secureString($entity, "&#39;"), 32, '...')?></a>.
    <?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), "sfReviewFront/show?id=".$review->getId())?>.
    <?php if ($review->getValue() == -1): ?>
  		<?php echo image_tag('icoMiniDown.png', 'width="16" height="18" alt="buu"') ?>
  	<?php endif ?>
  	<?php if ($review->getValue() == 1): ?>
  		<?php echo image_tag('icoMiniUp.png', 'width="16" height="18" alt="yeah"') ?>
  	<?php endif ?>
  </div>
  <p class="review-body">
    <?php echo review_text( $review ) ?>
  </p>
</li>
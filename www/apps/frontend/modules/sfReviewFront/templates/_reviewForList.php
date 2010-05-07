<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoUser'); ?>

<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $uc->add(SfReviewPeer::IS_ACTIVE, true); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1); $dc->add(SfReviewPeer::IS_ACTIVE, true);  ?>
<?php $listValue = isset($listValue)?$listValue:''?>

<li class="review" id="<?php echo "sf_review_c_m".$review->getId() ?>">
  <p class="review-body">
    <?php echo review_text( $review ) ?>
  </p>
  <p class="review-author">
    <?php echo getAvatar( $review->getsfGuardUser() ) ?>
    <?php echo link_to(fullName( $review->getsfGuardUser() ), '@usuario?username='.$review->getsfGuardUser()->getProfile()->getVanity())?>
    ,
    <?php echo __('sobre') ?>
    <?php // TODO: Sustituir por enlace a entidad comentada ?>
    <a href="#">Partido Socialista (PSOE)</a>
    ,
    <?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), "sfReviewFront/show?id=".$review->getId())?>
    <?php if ($review->getValue() == -1): ?>
  		<?php echo image_tag('icoMiniDown.png', 'alt="buu"') ?>
  	<?php endif ?>
  	<?php if ($review->getValue() == 1): ?>
  		<?php echo image_tag('icoMiniUp.png', 'alt="yeah"') ?>
  	<?php endif ?>
  </p>
</li>
<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $uc->add(SfReviewPeer::IS_ACTIVE, true); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1); $dc->add(SfReviewPeer::IS_ACTIVE, true);  ?>
<?php $listValue = isset($listValue)?$listValue:''?>

<li class="review" id="<?php echo "sf_review_c_m".$review->getId() ?>">

  <?php include_partial('sfReviewFront/user_header', array('review' => $review)) ?>

	<p class="review-date">
	  <?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), "sfReviewFront/show?id=".$review->getId())?>
	</p>
  <p class="review-body">
    <?php echo review_text( $review ) ?>
  </p>
  
	<?php if ($reviewable): ?>
    <?php include_partial('sfReviewFront/add_subreview', array('sf_user' => $sf_user, 'review' => $review, 'uc' => $uc, 'dc' => $dc, 'listValue' => $listValue)) ?>
    <?php include_partial('sfReviewFront/subreviews_summary', array('sf_user' => $sf_user, 'review' => $review, 'uc' => $uc, 'dc' => $dc, 'listValue' => $listValue)) ?>
	<?php endif ?>
</li>
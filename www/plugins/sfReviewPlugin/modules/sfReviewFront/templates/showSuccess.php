<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>

<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1) ?>
<?php $listValue = isset($listValue)?$listValue:''?>

<h2 class="review-body">
  <?php echo review_text( $review ) ?>
</h2>

<p class="review-about">
  <?php // TODO: Sustituir nombre de político, partido o propuesta, y corregir URL del enlace ?>
  <?php echo __('Sobre %nombre%', array('%nombre%' => link_to('Nombre del político/partido/propuesta', '@homepage')))?>
</p>

<?php include_partial('sfReviewFront/user_header', array('review' => $review)) ?>

<p class="review-date">
  <?php echo link_to(ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() )), "sfReviewFront/show?id=".$review->getId())?>
</p>

<?php if (!$review->getSfReviewId()): ?>
  <?php include_partial('sfReviewFront/add_subreview', array('sf_user' => $sf_user, 'review' => $review, 'uc' => $uc, 'dc' => $dc, 'listValue' => $listValue)) ?>
  <?php include_partial('sfReviewFront/subreviews_summary', array('sf_user' => $sf_user, 'review' => $review, 'uc' => $uc, 'dc' => $dc, 'listValue' => $listValue)) ?>
<?php endif ?>
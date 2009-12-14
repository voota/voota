<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1) ?>

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
	    <?php if(trim(review_text( $review )) != ''):?>
		    <br />
	    	<a href="#" onclick="document.getElementById('<?php echo "subreviews_box".$review->getId() ?>').className = 'subreviews shown';return loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $review->getId() ?>,  0, '<?php echo "sf_review_c".$review->getId() ?>' )"><?php echo __('Opinar sobre este comentario')?></a>
	    	<?php if( count($review->getSfReviewsRelatedBySfReviewId($uc)) > 0 || count($review->getSfReviewsRelatedBySfReviewId($dc)) > 0 ): ?> 
				<?php echo __('(Lleva') ?> 
		    	<?php if( count($review->getSfReviewsRelatedBySfReviewId($uc)) > 0  ): ?> 
		    		<?php echo count($review->getSfReviewsRelatedBySfReviewId($uc)) ?>
					<img alt="A favor, yeah" src="/images/icoMiniUp.png" />
				<?php endif ?>
				<?php if( count($review->getSfReviewsRelatedBySfReviewId($uc)) > 0 && count($review->getSfReviewsRelatedBySfReviewId($dc)) > 0 ): ?>
					<?php echo __(' y ') ?>
				<?php endif ?>
		    	<?php if( count($review->getSfReviewsRelatedBySfReviewId($dc)) > 0  ): ?> 
		    		<?php echo count($review->getSfReviewsRelatedBySfReviewId($dc)) ?>
					<img alt="En contra, buu" src="/images/icoMiniDown.png" />
				<?php endif ?>
				)
			<?php endif ?>
		<?php endif ?>
  </p>
  
	<?php if ($reviewable): ?>
		<div id="<?php echo "sf_review_sr_c".$review->getId() ?>" ><?php include_component_slot('subreviews', array('id' => $review->getId())) ?></div>
	<?php endif ?>
</li>
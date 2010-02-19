<?php use_helper('SfReview') ?>
<?php use_helper('I18N') ?>
<?php $reviewable = isset($reviewable)?$reviewable:false; $uc=new Criteria(); $uc->add(SfReviewPeer::VALUE, 1); $dc=new Criteria(); $dc->add(SfReviewPeer::VALUE, -1) ?>

<li class="review" id="<?php echo "sf_review_c_m".$review->getId() ?>">

  <?php include_partial('sfReviewFront/user_header', array('review' => $review)) ?>

	<p class="review-date">
	  <?php echo ago(strtotime( $review->getModifiedAt()?$review->getModifiedAt():$review->getCreatedAt() ))?>
	</p>
  <p class="review-body">
    <?php echo review_text( $review ) ?>
  </p>
  <?php if(trim(review_text( $review )) != ''):?>
    <p class="add-subreview">
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
      <?php if (!$sf_user->isAuthenticated()): ?>
        (<?php echo __('accede a %your_account% para opinar', array('%your_account%' => link_to(__('tu cuenta'), 'sfGuardAuth/signin'))) ?>)
      <?php endif ?>
    </p>
  <?php endif ?>
  
	<?php if ($reviewable): ?>
		<div id="<?php echo "sf_review_sr_c".$review->getId() ?>" ><?php include_component_slot('subreviews', array('id' => $review->getId())) ?></div>
	<?php endif ?>
</li>
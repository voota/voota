<?php if(trim(review_text( $review )) != ''):?>
  <p class="add-subreview">
  	<a href="#" onclick="<?php echo "$('#sf_review_sr_c${listValue}_".$review->getId()."').slideDown()" ?>;document.getElementById('<?php echo "subreviews_box${listValue}_".$review->getId() ?>').className = 'subreviews shown';return loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $review->getId() ?>,  0, '<?php echo "sfrc${listValue}_".$review->getId() ?>' )"><?php echo __('Opinar sobre este comentario')?></a>
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
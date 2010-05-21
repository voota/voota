<?php if(!$sf_user->isAuthenticated()): ?>
	<?php include_partial('sfReviewFront/dialog') ?>
<?php endif ?>

<?php if(trim(review_text( $review )) != ''):?>
  <?php 
  $isUpdate = false;
  if ($sf_user->isAuthenticated()){
	  foreach ( $review->getSfReviewsRelatedBySfReviewId() as $subreview ){
	  	if( $subreview->getSfGuardUserId() == $sf_user->getGuardUser()->getId() && $subreview->getIsActive()){
	  		$isUpdate = true;
	  	}
	  }
  }
  ?>
  <p class="add-subreview">
  <?php if($sf_user->isAuthenticated()): ?>
  	<a href="#" onclick="<?php echo "$('#sf_review_sr_c${listValue}_".$review->getId()."').slideDown()" ?>;document.getElementById('<?php echo "subreviews_box${listValue}_".$review->getId() ?>').className = 'subreviews shown';return loadReviewBox('<?php echo url_for('@sf_review_form') ?>', null,  <?php echo $review->getId() ?>,  0, '<?php echo "sfrc${listValue}_".$review->getId() ?>' )"><?php echo $isUpdate?__('Hacer cambios en tu opinión'):__('Opinar sobre este comentario')?></a>
  <?php else: ?>
  	<a href="#" onclick="ejem('<?php echo url_for('sfGuardAuth/signin');?>', '');return false;"><?php echo __('Opinar sobre este comentario')?></a>
  <?php endif ?>
  </p>
<?php endif ?>
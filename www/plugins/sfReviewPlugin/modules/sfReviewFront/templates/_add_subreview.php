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
  <?php //if($sf_user->isAuthenticated()): ?>
  <?php if(($sf_status = $sf_request->getAttribute('sfr_status', false)) && $sf_status['b'] == "sfrc${listValue}_".$review->getId()): ?>
  	<script type="text/javascript">
	  <!--
	  	$(document).ready(function(){
	  		subvote(
	  		  		'<?php echo "${listValue}_".$review->getId() ?>'
	  		  		, <?php echo $review->getId() ?>
	  		  		, <?php echo ($page = $sf_request->getAttribute('page', false))?$page:'FALSE' ?>
	  		  		, '<?php echo url_for('@sf_review_form') ?>'
	  		 );
	  	});
	  //-->
	</script>
  <?php else: ?>
  	<a href="#" onclick="return subvote(
	  		  		'<?php echo "${listValue}_".$review->getId() ?>'
	  		  		, <?php echo $review->getId() ?>
	  		  		, <?php echo ($page = $sf_request->getAttribute('page', false))?$page:'FALSE' ?>
	  		  		, '<?php echo url_for('@sf_review_form') ?>'
	  		 );	"><?php echo $isUpdate?__('Hacer cambios en tu opinión'):__('Opinar sobre este comentario')?></a>
  <?php endif ?>
  <?php /*else: ?>
  	<a href="#" onclick="ejem('<?php echo url_for('sfGuardAuth/signin');?>', '');return false;"><?php echo __('Opinar sobre este comentario')?></a>
  <?php endif*/ ?>
  </p>
<?php endif ?>
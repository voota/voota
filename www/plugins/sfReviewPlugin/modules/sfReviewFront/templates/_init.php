<div class="sf-review-hands <?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>">
  <div class="sf-review-positive">
		<input type="radio" name="v" value="1" id="v-<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>-positive" />
	  <label for="v-<?php echo $reviewBox ?>-positive">
		  	<img alt="yeah" src="/images/icoMiniUp.png" width="16" height="18" />
		  <br />
	    <?php echo __('A favor, yeah')?>
	  </label>
	</div>

	<div class="sf-review-negative">
		<input type="radio" name="v" value="-1" id="v-<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>-negative" />
		<label for="v-<?php echo $reviewBox ?>-negative">
		  	<img alt="buu" src="/images/icoMiniDown.png" width="16" height="18" />
	    <br />
	    <?php echo __('En contra, buu')?>
	  </label>
	</div>
</div>


<?php /* if(!$sf_user->isAuthenticated()): ?>
	<?php include_partial('sfReviewFront/dialog') ?>
<?php endif */ ?>
	
<script type="text/javascript">
<!--//
$(".<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?> .sf-review-positive input").click(function(){
	<?php //if(!$sf_user->isAuthenticated()): ?>
		//ejem('<?php echo url_for('sfGuardAuth/signin');?>', '');
	<?php //else: ?>
		loadReviewBox('<?php echo url_for('@sf_review_form') ?>', <?php echo $reviewTypeId ?>,  <?php echo $reviewEntityId ?>, 1,  '<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>');
	<?php //endif ?>
			sfr_refresh(<?php echo $reviewTypeId ?>);
});
$(".<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?> .sf-review-negative input").click(function(){
	<?php //if(!$sf_user->isAuthenticated()): ?>
		//ejem('<?php echo url_for('sfGuardAuth/signin');?>', '');
	<?php //else: ?>
		loadReviewBox('<?php echo url_for('@sf_review_form') ?>', <?php echo $reviewTypeId ?>, <?php echo $reviewEntityId ?>, -1, '<?php echo isset($reviewBox)?$reviewBox:'sf_review' ?>');
	<?php //endif ?>
			sfr_refresh(<?php echo $reviewTypeId ?>);
});
//-->
</script>

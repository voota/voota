<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>



<div>
	<h6>Tu voto
	<?php if ($reviewValue == -1): ?>
		<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
	<?php endif ?>
	<?php if ($reviewValue == 1): ?>
		<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
	<?php endif ?>
	<a href="#" 
		onclick="javascript:loadReviewBox(
			'<?php echo url_for('@sf_review_form') ?>'
			, 1
			, <?php echo $reviewEntityId ?>
			, <?php echo $reviewValue ?>
			, '<?php echo $reviewBox?$reviewBox:'sf_review'?>'
		)"
	><?php echo __('Hacer cambios')?></a>
	
	</h6>
</div>
<div class="izq">
	<div class="margenPolitico">
	  <h6><?php echo $reviewText ?></h6>
	</div>
</div>
	
	
	

<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('SfReview') ?>

<?php if ($reviewType): ?>
	<div class="review-current">
	  <p>
	    <?php echo __('Tu voto')?>: <?php echo $reviewValue == 1?__('A favor'):__('En contra')?>
		<br />
	  	<?php echo jq_link_to_remote(__('Hacer cambios'), array(
	  	  'update' => $reviewBox?$reviewBox:'sf_review',
	  	  'url'    => "@sf_review_form?t=$reviewType&e=$reviewEntityId&v=$reviewValue&b=".($reviewBox?$reviewBox:'sf_review'),
	  	  'before' => "re_loading('".($reviewBox?$reviewBox:'sf_review')."')"
	  	)) ?>	
	  </p>
	
	  <p><?php echo review_text( $review ) ?></p>
	</div>
<?php endif ?>
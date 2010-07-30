<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('SfReview') ?>

<?php if ($reviewType): ?>
	<div class="review-current">
	  <h5>
	    <strong><?php echo __('Tu voto')?>:</strong> <?php echo $reviewValue == 1?__('A favor'):__('En contra')?>
  		<br />
  		<span class="sf-review-action">
  	  	<?php echo jq_link_to_remote(__('Hacer cambios en tu voto'), array(
  	  	  'update' => $reviewBox?$reviewBox:'sf_review',
  	  	  'url'    => "@sf_review_form?t=$reviewType&e=$reviewEntityId&v=$reviewValue&b=".($reviewBox?$reviewBox:'sf_review'),
  	  	  'before' => "re_loading('".($reviewBox?$reviewBox:'sf_review')."')"
  	  	)) ?>
  	  </span>
	  </h5>
	
	  <p><?php echo review_text( $review ) ?></p>
	</div>
<?php endif ?>


<?php if ( $twAuthUrl = $sf_request->getAttribute('twAuthUrl', false) ): ?>
	Cargando popup de auth twitter en <?php echo $twAuthUrl ?> 
<?php endif ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('SfReview') ?>

<div class="review-current">
  <p>
    <?php echo __('Tu voto')?>
  	<?php if ($reviewValue == -1): ?>
  		<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
  	<?php endif ?>
  	<?php if ($reviewValue == 1): ?>
  		<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
  	<?php endif ?>
  	<?php echo jq_link_to_remote(__('Hacer cambios'), array(
  	  'update' => $reviewBox?$reviewBox:'sf_review',
  	  'url'    => "@sf_review_form?t=$reviewType&e=$reviewEntityId&v=$reviewValue&b=".($reviewBox?$reviewBox:'sf_review'),
  	  'before' => "re_loading('".($reviewBox?$reviewBox:'sf_review')."')"
  	)) ?>	
  </p>

  <p><?php echo review_text( $review ) ?></p>
</div>
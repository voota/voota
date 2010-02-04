<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
	
<?php //include_component_slot('sendStmt', array('reviewBox' => $reviewBox, 'reviewType' => $reviewType, 'reviewEntityId' => $reviewEntityId)) ?>
<script type="text/javascript">
  <!--//
$(document).ready(function() {
	  //controls character input/counter
	  $('#<?php echo "sf-review-text_$reviewBox" ?>').keyup(function() {
		  setCounter('#<?php echo "sf-review-counter_$reviewBox" ?>', this, <?php echo $maxLength?>);
	  });
	  setCounter('#<?php echo "sf-review-counter_$reviewBox" ?>', '#<?php echo "sf-review-text_$reviewBox" ?>', <?php echo $maxLength?>);  
	  subscribeHint('#<?php echo "sf-review-text_$reviewBox" ?>', 'blur');
	  $('#<?php echo "sf-review-form-$reviewBox" ?>').submit(function() {
		  removeHint('#<?php echo "sf-review-text_$reviewBox" ?>', 'blur');
	      <?php include_component_slot('sendStmt', array('reviewBox' => $reviewBox, 'reviewType' => $reviewType, 'reviewEntityId' => $reviewEntityId, 'reviewId' => $reviewId)) ?>
		  return false;
	  });
});
  //-->
</script>

<?php /*echo jq_form_remote_tag(array(
    'update'   => $reviewBox?$reviewBox:'sf_review',
    'url'      => 'sfReviewFront/send',
	'before' => "removeHint('#sf-review-text_$reviewBox', 'blur')"
))*/ ?>
<form action="#" id="<?php echo "sf-review-form-$reviewBox" ?>">
	<input type="hidden" id="t" name="t" value="<?php echo $reviewType ?>" />
	<input type="hidden" id="e" name="e" value="<?php echo $reviewEntityId ?>" />
	<input type="hidden" id="b" name="b" value="<?php echo $reviewBox ?>" />
	<input type="hidden" id="i" name="i" value="<?php echo $reviewId ?>" />

	<?php if ($reviewId != ''): ?>
		<h5>
		  <?php echo __('Tu opinión') ?>
		  <span class="sf-review-cancel">
		    <?php echo jq_link_to_remote(__('Dejarlo como estaba'), array(
				    'update'   => $reviewBox?$reviewBox:'sf_review',
				    'url'    => "@sf_review_init?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
				)) ?>
		  </span>
		</h5>
	<?php endif?>
	<div class="sf-review-hands">
    <div class="sf-review-positive">
			<input type="radio" name="v" value="1" id="v-<?php echo $reviewId ?>-positive" <?php if ($reviewValue==1 || $reviewValue==0): echo 'checked="checked"'; endif ?> />
		  <label for="v-<?php echo $reviewId ?>-positive">
		    <?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
  		  <br />
		    <?php echo __('A favor, yeah')?>
		  </label>
		</div>

		<div class="sf-review-negative">
			<input type="radio" name="v" value="-1" id="v-<?php echo $reviewId ?>-negative" <?php if ($reviewValue==-1): echo 'checked="checked"'; endif ?> />
			<label for="v-<?php echo $reviewId ?>-negative">
		    <?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
		    <br />
		    <?php echo __('En contra, buu')?>
		  </label>
		</div>
	</div>

  <p id="sf-review-body">
    <textarea id="<?php echo "sf-review-text_$reviewBox" ?>" name="review_text" class="sf-review-text sfr" title="<?php echo __('¿Algo que comentar? Es el mejor momento :-)') ?>"><?php echo $reviewText ?></textarea>
    <div id="<?php echo "sf-review-counter_$reviewBox" ?>" class="sf-review-counter"></div>
  </p>

  <?php if ($reviewId != ''): ?>
	  <?php if (!isset($cf)): ?>
	    <p class="sf-review-remove">
				<?php echo jq_link_to_remote(__('Eliminar opinión'), array(
			    'update'   => $reviewBox?$reviewBox:'sf_review',
			    'url'    => "@sf_review_delete?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
				)) ?>
			</p>
	  <?php else: ?>
	  	<p class="sf-review-remove">
	  	  <?php echo __('¿Seguro?') ?>
	  	  <span>
  	  	  <?php echo jq_link_to_remote(__('Sí'), array(
  			    'update'   => $reviewBox?$reviewBox:'sf_review',
  			    'url'    => "@sf_review_delete?i=$reviewId&e=$reviewEntityId&t=$reviewType&cf=1".($reviewBox==''?'':"&b=$reviewBox"),		    		
  	  				'before' => "re_loading('".($reviewBox?$reviewBox:'sf_review')."')"
  			  )) ?>
			  </span>
			  <span>
			    <?php echo jq_link_to_remote(__('No'), array(
			      'update'   => $reviewBox?$reviewBox:'sf_review',
			      'url'    => "@sf_review_form?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),	
			)) ?>
			  </span>
			</p>
		<?php endif ?>
  <?php endif ?>

  <?php 
	  /*
	  <p>Foto/vídeo: <a href="#">desde el equipo</a> · <a href="#">desde la web</a>
	    <input name="fileField" type="file" id="fileField">
	  </p>
  */?>

  <p class="submit">
  	<input type="submit" value="<?php echo __('Enviar')?>" class='sfr_button', id="<?php echo ($reviewBox?$reviewBox:'sf_review').'_button' ?>"  />
  </p>
</form>
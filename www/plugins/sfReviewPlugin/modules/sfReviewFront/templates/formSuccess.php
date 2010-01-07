<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
	
<script type="text/javascript">
  <!--
$(document).ready(function() {
  <?php if($reviewId == ''): ?>
  	$("#<?php echo ($reviewBox?$reviewBox:'sf_review').'_button' ?>").click(function () {
  		if (!<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited){
  			$('#<?php echo "sf-review-text_$reviewBox" ?>').val('');
  		}
  		return true;
  	});
  <?php endif ?>
  <?php if($reviewId == ''): ?>
    var <?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited = false;
    $('#<?php echo "sf-review-text_$reviewBox" ?>').focus(function() {
    	MAX_LENGTH = <?php echo $maxLength?>;
	
    	if (!<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited){
    		$(this).val('');
    		$(this).removeClass('sfr_grey');
    		$('#<?php echo "sf-review-counter_$reviewBox" ?>').html(MAX_LENGTH);
    		<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited = true;
    	}
    });
  <?php endif ?>
  //controls character input/counter
	  //controls character input/counter
	  $('#<?php echo "sf-review-text_$reviewBox" ?>').keyup(function() {
		  setCounter('#<?php echo "sf-review-counter_$reviewBox" ?>', this, <?php echo $maxLength?>);
	  });
	  setCounter('#<?php echo "sf-review-counter_$reviewBox" ?>', '#<?php echo "sf-review-text_$reviewBox" ?>', <?php echo $maxLength?>);  
});
  //-->
</script>

<?php echo jq_form_remote_tag(array(
    'update'   => $reviewBox?$reviewBox:'sf_review',
    'url'      => 'sfReviewFront/send',
)) ?>
	<?php echo input_hidden_tag('t', $reviewType) ?>
	<?php echo input_hidden_tag('e', $reviewEntityId) ?>
	<?php echo input_hidden_tag('v', $reviewValue) ?>
	<?php echo input_hidden_tag('b', $reviewBox) ?>
	<?php echo input_hidden_tag('i', $reviewId) ?>

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

  <?php $aReviewText = $reviewText || $reviewId != ''?$reviewText:__('¿Algo que comentar? Es el mejor momento :-)') ?>
  <p id="<?php echo "sf-review-counter_$reviewBox" ?>" class="sf-review-counter"></p>
  <p id="sf-review-body">
    <textarea id="<?php echo "sf-review-text_$reviewBox" ?>" name="review_text" class="sf-review-text sfr<?php if($reviewId == ''): ?> sfr_grey<?php endif ?>"><?php echo $aReviewText ?></textarea>
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
    <?php echo submit_tag(__('Enviar'), array('class' => 'sfr_button', 'id' => ($reviewBox?$reviewBox:'sf_review').'_button' )) ?>
  </p>
</form>
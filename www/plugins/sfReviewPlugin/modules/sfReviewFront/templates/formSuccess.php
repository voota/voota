<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
	
<script type="text/javascript">
  <!--
  <?php if($reviewId == ''): ?>
  	$("#<?php echo ($reviewBox?$reviewBox:'sf_review').'_button' ?>").click(function () {
  		if (!<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited){
  			$('#sf-review-text').val('');
  		}
  		return true;
  	});
  <?php endif ?>
  <?php if($reviewId == ''): ?>
    var <?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited = false;
    $('#sf-review-text').focus(function() {
    	MAX_LENGTH = <?php echo $maxLength?>;
	
    	if (!<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited){
    		$(this).val('');
    		$(this).removeClass('sfr_grey');
    		$('#sf-review-counter').html(MAX_LENGTH);
    		<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited = true;
    	}
    });
  <?php endif ?>
  //controls character input/counter
  $('#sf-review-text').keyup(function() {
  	MAX_LENGTH = <?php echo $maxLength?>;
	
  	var charLength = $(this).val().length;
  	if((MAX_LENGTH - charLength) < -50) {
  		$(this).val( $(this).val().substr(0, MAX_LENGTH+50) );
  		charLength = $(this).val().length;
  	}
  	else if((MAX_LENGTH - charLength) < 0) {
  		$('#sf-review-counter').attr('style', 'color:red;');
  	}
  	else if((MAX_LENGTH - charLength) < 40) {
  		$('#sf-review-counter').attr('style', 'color:orange;');
  	}
  	else {
  		$('#sf-review-counter').attr('style', '');
  	}
  	$('#sf-review-counter').html(MAX_LENGTH - charLength);
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
			<?php echo radiobutton_tag('v', '1', ($reviewValue == '0' || $reviewValue==1)?true:false) ?>
		  <label for="v_1">
		    <?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
  		  <br />
		    <?php echo __('A favor, yeah')?>
		  </label>
		</div>

		<div class="sf-review-negative">
			<?php echo radiobutton_tag('v', '-1', ($reviewValue==-1)?true:false) ?>
			<label for="v_-1">
		    <?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
		    <br />
		    <?php echo __('En contra, buu')?>
		  </label>
		</div>
	</div>

  <?php $aReviewText = $reviewText || $reviewId != ''?$reviewText:__('¿Algo que comentar? Es el mejor momento :-)') ?>
  <p id="sf-review-counter"><?php echo $maxLength - strlen( $aReviewText )?></p>
  <p id="sf-review-body">
    <textarea id="sf-review-text" name="review_text" class="sfr<?php if($reviewId == ''): ?> sfr_grey<?php endif ?>"><?php echo $aReviewText ?></textarea>
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

  <p>
    <?php echo submit_tag(__('Enviar'), array('class' => 'sfr_button', 'id' => ($reviewBox?$reviewBox:'sf_review').'_button' )) ?>
  </p>
</form>
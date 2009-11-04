<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
	
<?php echo jq_form_remote_tag(array(
    'update'   => $reviewBox?$reviewBox:'sf_review',
    'url'      => 'sfReviewFront/send',
)) ?>
	<?php echo input_hidden_tag('t', $reviewType) ?>
	<?php echo input_hidden_tag('e', $reviewEntityId) ?>
	<?php echo input_hidden_tag('v', $reviewValue) ?>
	<?php echo input_hidden_tag('b', $reviewBox) ?>
	<?php echo input_hidden_tag('i', $reviewId) ?>

	<div class="votaSobre">
		<div class="izq">
			<?php echo radiobutton_tag('v', '1', ($reviewValue==1)?true:false) ?>
		
		<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
		  <br>
		  <h6><?php echo __('A favor, yeah')?></h6> </div>
		
		<div>
			<?php echo radiobutton_tag('v', '-1', ($reviewValue==-1)?true:false) ?>
		<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
		  <br>
		
		  <h6><?php echo __('En contra, buu')?></h6>
		</div>
	</div>

	<div title="formulario">
		<div>
		  <span id="sf_review_counter"><?php echo $maxLength - strlen($reviewText?$reviewText:__('Algo que comentar? Es el mejor momento :-)'))?></span>
		  <textarea id="sf_review_text" name="review_text" class="textarea"><?php echo $reviewText?$reviewText:__('Algo que comentar? Es el mejor momento :-)') ?></textarea>
		  <?php if ($reviewId != ''): ?>
			<h6><?php echo __('Eliminar')?></h6>
		  <?php endif ?>
<script type="text/javascript">
//controls character input/counter
$('textarea#sf_review_text').keyup(function() {
	const MAX_LENGTH = <?php echo $maxLength?>;
	
	var charLength = $(this).val().length;
	if((MAX_LENGTH - charLength) < -50) {
		$(this).val( $(this).val().substr(0, MAX_LENGTH+50) );
		charLength = $(this).val().length;
	}
	else if((MAX_LENGTH - charLength) < 0) {
		$('span#sf_review_counter').attr('style', 'color:red;');
	}
	else if((MAX_LENGTH - charLength) < 10) {
		$('span#sf_review_counter').attr('style', 'color:orange;');
	}
	else {
		$('span#sf_review_counter').attr('style', '');
	}
	$('span#sf_review_counter').html(MAX_LENGTH - charLength);
});
</script>		  
		  <?php 
		  /*
		  <h6>Foto/vídeo: <a href="#">desde el equipo</a> · <a href="#">desde la web</a></h6>
		    <h6><label>
		    <input name="fileField" type="file" id="fileField">
		    </label></h6>
		   */?>
		   <h6>&nbsp;</h6>
		  <h6>
		    <label>
		    
	<?php echo submit_tag(__('Enviar'), array('class' => 'button')) ?>
		    </label>
		  </h6>
		
		</div>
	</div>
	
</form>
	
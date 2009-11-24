<div class="sfr">
<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
	
<script type="text/javascript">
<!--
<?php if($reviewId == ''): ?>
	$("#<?php echo ($reviewBox?$reviewBox:'sf_review').'_button' ?>").click(function () {
		if (!<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited){
			$('textarea#sf_review_text').val('');
		}
		return true;
	});
<?php endif ?>
<?php if($reviewId == ''): ?>
var <?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited = false;
$('textarea#sf_review_text').focus(function() {
	MAX_LENGTH = <?php echo $maxLength?>;
	
	if (!<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited){
		$(this).val('');
		$(this).removeClass('sfr_grey');
		$('span#sf_review_counter').html(MAX_LENGTH);
		<?php echo ($reviewBox?$reviewBox:'sf_review').'_form' ?>_edited = true;
	}
});
<?php endif ?>
//controls character input/counter
$('textarea#sf_review_text').keyup(function() {
	MAX_LENGTH = <?php echo $maxLength?>;
	
	var charLength = $(this).val().length;
	if((MAX_LENGTH - charLength) < -50) {
		$(this).val( $(this).val().substr(0, MAX_LENGTH+50) );
		charLength = $(this).val().length;
	}
	else if((MAX_LENGTH - charLength) < 0) {
		$('span#sf_review_counter').attr('style', 'color:red;');
	}
	else if((MAX_LENGTH - charLength) < 40) {
		$('span#sf_review_counter').attr('style', 'color:orange;');
	}
	else {
		$('span#sf_review_counter').attr('style', '');
	}
	$('span#sf_review_counter').html(MAX_LENGTH - charLength);
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
	<h5 class="sfr">Tu opinión</h5>
	<span class="sfr">&nbsp;
		<?php echo jq_link_to_remote(__('Dejarlo como estaba'), array(
		    'update'   => $reviewBox?$reviewBox:'sf_review',
		    'url'    => "@sf_review_init?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
		)) ?>
	</span>
	<?php endif?>
	<div class="sfr_hands">
		<div class="sfr_margin">
			<?php echo radiobutton_tag('v', '1', ($reviewValue==1)?true:false) ?>
		
		<?php echo image_tag('icoUp.gif', 'alt="yeah"') ?>
		  <br>
		  <span class="sfr"><?php echo __('A favor, yeah')?></span> </div>
		
		<div>
			<?php echo radiobutton_tag('v', '-1', ($reviewValue==-1)?true:false) ?>
		<?php echo image_tag('icoDown.gif', 'alt="buu"') ?>
		  <br>
		
		  <span class="sfr"><?php echo __('En contra, buu')?></span>
		</div>
	</div>

	<div title="formulario">
		<div>
		  <?php $aReviewText = $reviewText || $reviewId != ''?$reviewText:__('Algo que comentar? Es el mejor momento :-)') ?>
		  <span id="sf_review_counter"><?php echo $maxLength - strlen( $aReviewText )?></span>
		  <textarea id="sf_review_text" name="review_text" class="sfr<?php if($reviewId == ''): ?> sfr_grey<?php endif ?>"><?php echo $aReviewText ?></textarea>
		  <?php if ($reviewId != ''): ?>
			  
			  <?php if (!isset($cf)): ?>
			    <span class="sfr">
				<?php echo jq_link_to_remote(__('Eliminar opinión'), array(
				    'update'   => $reviewBox?$reviewBox:'sf_review',
				    'url'    => "@sf_review_delete?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
				)) ?>
				</span>
			  <?php else: ?>
			  	<div class="sfr_margin">
				  	<span class="sfr"><?php echo __('¿Seguro?') ?></span>
				</div> 
			  	<div class="sfr_margin">
				<span class="sfr"><?php echo jq_link_to_remote(__('Sí'), array(
				    'update'   => $reviewBox?$reviewBox:'sf_review',
				    'url'    => "@sf_review_delete?i=$reviewId&e=$reviewEntityId&t=$reviewType&cf=1".($reviewBox==''?'':"&b=$reviewBox"),
				)) ?></span>
				</div>
			  	<div class="sfr_left">
				<span class="sfr"><?php echo jq_link_to_remote(__('No'), array(
				    'update'   => $reviewBox?$reviewBox:'sf_review',
				    'url'    => "@sf_review_form?i=$reviewId&e=$reviewEntityId&t=$reviewType".($reviewBox==''?'':"&b=$reviewBox"),
				)) ?></span>
				</div>
			  <?php endif ?>
			
		  <?php endif ?>
		  <?php 
		  /*
		  <span class="sfr">Foto/vídeo: <a href="#">desde el equipo</a> · <a href="#">desde la web</a></span>
		    <span class="sfr"><label>
		    <input name="fileField" type="file" id="fileField">
		    </label></span>
		   */?>
		   <span class="sfr">&nbsp;</span>
		    <label>
		    
	<?php echo submit_tag(__('Enviar'), array('class' => 'sfr_button', 'id' => ($reviewBox?$reviewBox:'sf_review').'_button' )) ?>
		    </label>
		
		</div>
	</div>
	
</form>
</div>
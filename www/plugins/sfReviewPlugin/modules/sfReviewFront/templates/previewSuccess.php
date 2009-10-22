<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

	<?php echo jq_form_remote_tag(array(
	    'update'   => 'sf_review',
	    'url'      => '@sf_review_send',
		'id'	=> 'preview_frm'
	)) ?>
	
	<?php echo input_hidden_tag('v', $reviewValue) ?>
	<?php echo input_hidden_tag('t', $reviewType) ?>
	<?php echo input_hidden_tag('e', $reviewEntityId) ?>
	<?php echo input_hidden_tag('review_text', $reviewText) ?>

	
	<div class="izq confirmar">
	<div class="cuadroConfirmar">
	  <h6><?php echo $reviewText ?></h6>
	</div>
	<div class="margenVota"><h6><a href="#">&lt;&lt; atras</a> 
	  <label>
	  <input type="submit" name="button3" value="Ok, confirmar" class="button">
	
	  </label>
	  </h6>
	</div>
	</div>
	
	
	
	</form>
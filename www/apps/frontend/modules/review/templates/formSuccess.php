<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
	
	<?php echo jq_form_remote_tag(array(
	    'update'   => 'sf_review',
	    'url'      => 'review/preview',
	)) ?>
	<?php echo input_hidden_tag('t', $reviewType) ?>
	<?php echo input_hidden_tag('e', $reviewEntityId) ?>
	
<div class="votaSobre">
<div class="izq" id="button">
	<?php echo radiobutton_tag('v', '1', ($reviewValue==1)?true:false) ?>

  <img src="/images/icoUp.gif" alt="Icono Up" width="27" height="36" longdesc="Icono mano Up">
  <br>
  <h6>A favor, yeah</h6> </div>

<div class="izq">
	<?php echo radiobutton_tag('v', '-1', ($reviewValue==-1)?true:false) ?>
  <img src="/images/icoDown.gif" alt="Icono Down" width="27" height="36" longdesc="Icono mano Down"> <br>

  <h6>En contra, buu</h6>
</div></div>

	<div title="formulario" class="votaSobre">
	<div class="izq">
	  <textarea name="review_text" rows="20" cols="20" >Algo que comentar? Es el mejor momento :-)</textarea>
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
	    <input name="button" type="submit" class="button" id="buttonq" value="Previsualizar comentario">
	    </label>
	  </h6>

	</div>
	</div>
		
	</form>
	
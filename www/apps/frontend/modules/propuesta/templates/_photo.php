<div id="photo-box">
  <script type="text/javascript">
    <!--
    $(document).ready(function(){
    	  $('#edit-photo').click(function(){
      	    $('#edit2-photo-box').hide();
    	  	    $('#edit-photo-box').show();
    	  			return false;
    	  	  });
        	$('.cancel_delete').click(function(){
          	    $('#edit-photo-box').hide();
        	    $('#edit2-photo-box').hide();
            	return false;
    		});
          	$('.confirm_delete').click(function(){
          	    $('#edit-photo-box').hide();
        	    $('#edit2-photo-box').show();
            	return false;
    		});
        	$('#close-ed-photo-box').click(function(){
          	    $('#edit-photo-box').hide();
        	    $('#edit2-photo-box').hide();
            	return false;
    		});
          	
    });
    //-->
  </script>
  
  <?php echo image_tag(S3Voota::getImagesUrl().'/propuestas/cc_'.$propuesta->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' => $propuesta->getTitulo())) .'"') ?>
  <?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
	  <p><a href="#" id="edit-photo" class="edit-link"><?php echo __('Hacer cambios')?></a></p>
  <?php endif ?>
</div>

<?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>  
	<div id="edit-photo-box" class="edit-box" style="display:none">
	  <a href="#" class="confirm_delete"><?php echo __('¿Sustituir?') ?></a>
	  <a href="#" class="confirm_delete"><?php echo __('Sí') ?></a>
	  <a href="#" class="cancel_delete"><?php echo __('No') ?></a>
	  <a href="#" class="cancel_delete close-edit-box" id="close-edit-photo-box"><?php echo __('(Cerrar)') ?></a>
	</div>

	<div id="edit2-photo-box" class="edit-box" style="display:none">
	  <h4><?php echo __('Añadir nueva imagen') ?></h4>
	  <p><?php echo __('JPG, GIF, PNG... (Máx 2Mb)') ?></p>
	  <form method="post" id="edit-photo-form" enctype="multipart/form-data" action="<?php echo url_for('propuesta/editDoc?id='.$propuesta->getId()) ?>">
		<div><input type="hidden" name="op" value="ep" /></div>
	    <p><input type="file" name="img" /></p>
	    <p><input type="submit" value="Guardar" /></p>
	  </form>
	  <a href="#" class="cancel-delete close-edit-box" id="close-ed-photo-box"><?php echo __('(Cerrar)') ?></a>
	</div>
<?php endif ?>


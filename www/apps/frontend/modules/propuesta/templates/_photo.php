<div id="photo-box">
  <script type="text/javascript">
    <!--
    $(document).ready(function(){
  	  $('#edit-photo').click(function(){
  	    $('#edit-photo-box').show();
  			re_loading( 'edit-photo-box' );
  			// TODO: Añadir dirección de edición de foto en url
  			jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#edit-photo-box').html(data);},url:''});
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

<?php // TODO: Separar en las vistas necesarias ?>

<div id="edit-photo-box" class="edit-box">
  <a href="#" class="confirm_delete"><?php echo __('¿Sustituir?') ?></a>
  <a href="#" class="confirm_delete"><?php echo __('Sí') ?></a>
  <a href="#" class="cancel_delete"><?php echo __('No') ?></a>
  <a href="#" class="cancel_delete close-edit-box" id="close-edit-photo-box"><?php echo __('(Cerrar)') ?></a>
</div>

<div id="edit-photo-box" class="edit-box">
  <h4><?php echo __('Añadir nueva imagen') ?></h4>
  <p><?php echo __('JPG, GIF, PNG... (Máx 2Mb)') ?></p>
  <?php // TODO: Action del form ?>
  <form method="post" id="edit-photo-form" enctype="multipart/form-data" action="">
    <p><input type="file" name="photo"></p>
    <p><input type="submit" value="Guardar"></p>
  </form>
  <a href="#" class="cancel-delete close-edit-box" id="close-ed-photo-box"><?php echo __('(Cerrar)') ?></a>
</div>


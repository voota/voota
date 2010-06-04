<div id="descripcion-box">
  <script type="text/javascript">
    <!--
    $(document).ready(function(){
  	  $('#edit-descripcion').click(function(){
  	    $('#edit-descripcion-box').show();
  			re_loading( 'edit-descripcion-box' );
  			// TODO: Añadir dirección de edición de descripción en url
  			jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#edit-descripcion-box').html(data);},url:''});
  			return false;
  	  });
    });
    //-->
  </script>

  <?php echo formatPresentacion($propuesta->getDescripcion()) ?>
  <?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
	  <p><a href="#" id="edit-descripcion" class="edit-link"><?php echo __('Hacer cambios')?></a></p>
  <?php endif ?>
</div>

<?php // TODO: Separar en las vistas necesarias ?>

<div id="edit-descripcion-box" class="edit-box">
  <?php // TODO: Action del form ?>
  <form method="post" id="edit-descripcion-form" enctype="multipart/form-data" action="">
    <p><textarea name="descripcion" rows="20" cols="30"><?php echo $propuesta->getDescripcion() ?></textarea></p>
    <p><input type="submit" value="Guardar"></p>
  </form>
  <a href="#" class="cancel-delete close-edit-box" id="close-ed-descripcion-box"><?php echo __('(Cerrar)') ?></a>
</div>
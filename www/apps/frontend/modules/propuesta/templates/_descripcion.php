<div id="descripcion-box">
  <script type="text/javascript">
    <!--
    $(document).ready(function(){
    	  $('#edit-descripcion').click(function(){
    	  	    $('#edit-descripcion-box').show();
    	  			return false;
    	  	  });
      	  $('#close-ed-descripcion-box').click(function(){
        	    $('#edit-descripcion-box').hide();
        			return false;
        	  });
    	  
    	  $('#propuesta_descripcion').keyup(function() {
    		  setCounter('#propuesta_descripcion_counter', this, 600);
    	  });
    	  setCounter('#propuesta_descripcion_counter', '#propuesta_descripcion', 600);
    });
    //-->
  </script>



  <?php echo formatPresentacion($propuesta->getDescripcion(), ($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId())?
  	" <a href=\"#\" id=\"edit-descripcion\" class=\"edit-link\">". __('Hacer cambios') ."</a>":''
  ) ?>
</div>


<?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
	<div id="edit-descripcion-box" class="edit-box" style="display:none">
	  <?php // TODO: Action del form ?>
	  <form method="post" id="edit-descripcion-form" enctype="multipart/form-data" action="<?php echo url_for('propuesta/editDoc?id='.$propuesta->getId()) ?>">
		<div><input type="hidden" name="op" value="ed" /></div>
	    <p><textarea name="descripcion" id="propuesta_descripcion" rows="20" cols="30"><?php echo $propuesta->getDescripcion() ?></textarea></p>
        <p id="propuesta_descripcion_counter" class="counter"></p>
	    <p><input type="submit" value="Guardar" /></p>
	  </form>
	  <a href="#" class="cancel-delete close-edit-box" id="close-ed-descripcion-box"><?php echo __('(Cerrar)') ?></a>
	</div>
<?php endif ?>
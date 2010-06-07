<div id="titulo-box">
  <script type="text/javascript">
    <!--
    $(document).ready(function(){
  	  $('#edit-titulo').click(function(){
  	    $('#edit-titulo-box').show();
  			re_loading( 'edit-titulo-box' );
  			// TODO: Añadir dirección de edición de descripción en url
  			jQuery.ajax({type:'GET',dataType:'html',success:function(data, textStatus){jQuery('#edit-titulo-box').html(data);},url:''});
  			return false;
  	  });
    });
    //-->
  </script>
  
  <h2 id="name">
    <?php echo $propuesta->getTitulo(); ?>
    <?php include_partial('general/sparkline_box', array('reviewable' => $propuesta, 'id' => 'sparkline_pt_'.$propuesta->getId())) ?>    
    <span class="rank">
      <?php echo format_number_choice('[0]%1% votos positivos|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $propuesta->getSumu()), $propuesta->getSumu()) ?>
    </span>
  </h2>

  <p id="author">
    <?php echo __('Propuesta por')?>
    <?php echo getAvatar( $propuesta->getSfGuardUser(), 19, 19 )?>
  	<a href="<?php echo url_for('perfil/show?username='.$propuesta->getSfGuardUser()->getProfile()->getVanity())?>"><?php echo $propuesta->getSfGuardUser()?></a>,
    <?php echo __('el %fecha%', array('%fecha%' => format_date($propuesta->getCreatedAt())))?>
    <?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
  	  <a href="#" id="edit-titulo" class="edit-link"><?php echo __('Hacer cambios')?></a>
    <?php endif ?>
  </p>
</div>

<?php // TODO: Separar en las vistas necesarias ?>
<?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
	<div id="edit-titulo-box" class="edit-box" style="display:none">
	  <?php // TODO: Action del form ?>
	  <form method="post" id="edit-titulo-form" enctype="multipart/form-data" action="">
	    <p><textarea name="titulo" rows="4" cols="30"><?php echo $propuesta->getTitulo() ?></textarea></p>
	    <p><input type="submit" value="Guardar" /></p>
	  </form>
	  <a href="#" class="cancel-delete close-edit-box" id="close-ed-titulo-box"><?php echo __('(Cerrar)') ?></a>
	</div>
<?php endif ?>
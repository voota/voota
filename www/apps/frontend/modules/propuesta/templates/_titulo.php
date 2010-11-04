<div id="titulo-box">
  <script type="text/javascript">
    <!--
    $(document).ready(function(){
    	  $('#edit-titulo').click(function(){
    	  	    $('#edit-titulo-box').show();
    	  			return false;
    	  	  });
      	  $('#close-ed-titulo-box').click(function(){
        	    $('#edit-titulo-box').hide();
        			return false;
        	  });
          $('#propuesta_titulo').keyup(function() {
    		  setCounter('#propuesta_titulo_counter', this, 80);
    	  });
    	  setCounter('#propuesta_titulo_counter', '#propuesta_titulo', 80);
    });
    //-->
  </script>
  
  <h2 id="name">
    <?php echo $propuesta->getTitulo(); ?>
    <?php include_partial('general/sparkline_box', array('reviewable' => $propuesta, 'id' => 'sparkline_pt_'.$propuesta->getId())) ?>    
    <span class="rank">
      <?php echo format_number_choice('[0]%1% votos positivos|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $propuesta->getSumu()), $propuesta->getSumu()) ?>
      <?php echo format_number_choice('[0] y %1% votos negativos|[1] y 1 voto negativo|(1,+Inf] y %1% votos negativos', array('%1%' => $propuesta->getSumd()), $propuesta->getSumd()) ?>
    </span>
  </h2>

  <p id="author">
    <?php echo __('Propuesta por')?>
    <?php echo getAvatar( $propuesta->getSfGuardUser(), 19, 19 )?>
  	<a href="<?php echo url_for('perfil/show?username='.$propuesta->getSfGuardUser()->getProfile()->getVanity())?>"><?php echo fullname($propuesta->getSfGuardUser())?></a>,
    <?php echo __('el %fecha%', array('%fecha%' => format_date($propuesta->getCreatedAt())))?>
    <?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
  	  <a href="#" id="edit-titulo" class="edit-link"><?php echo __('Hacer cambios')?></a>
    <?php endif ?>
  </p>
</div>

<?php if($sf_user->isAuthenticated() && $propuesta->getSfGuardUserId() == $sf_user->getGuardUser()->getId()): ?>
	<div id="edit-titulo-box" class="edit-box" style="display:none">
	  <form method="post" id="edit-titulo-form" action="<?php echo url_for('propuesta/editDoc?id='.$propuesta->getId()) ?>">
		<div><input type="hidden" name="op" value="et" /></div>
	    <p><textarea name="titulo" id="propuesta_titulo" rows="4" cols="30"><?php echo $propuesta->getTitulo() ?></textarea></p>
        <p id="propuesta_titulo_counter" class="counter"></p>
	    <p><input type="submit" value="Guardar" /></p>
	  </form>
	  <a href="#" class="cancel-delete close-edit-box" id="close-ed-titulo-box"><?php echo __('(Cerrar)') ?></a>
	</div>
<?php endif ?>
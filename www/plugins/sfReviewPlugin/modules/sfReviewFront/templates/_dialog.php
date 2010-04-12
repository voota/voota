<?php if (!isset($GLOBALS['sf_dialog_included'])): ?>
<div id="sfr_dialog">
  <h3><?php echo __('Ejem. Para votar necesitas tener una cuenta en Voota.')?></h3>
  <p>
    <?php echo __('Si no tienes cuenta aun, este es el mejor momento. Luego volveremos por aquí.')?>
    <?php echo __('¿Vamos a ello?')?>
  </p>
	  
  <form action="<?php echo url_for('sfGuardAuth/signin');?>" id="sfr_dialog_form" method="get">
	  <div class="submit"><input type="submit" value="<?php echo __('Hacer login o crear una cuenta')?>" class="login_or_register" /></div>
  </form>
</div>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $("#sfr_dialog").dialog({ autoOpen: false, resizable: false, modal: true, closeText: '<?php echo __('cerrar')?>' });
  });
</script>
<?php $GLOBALS['sf_dialog_included'] = true ?><?php endif ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	    $('#take_confirm_button').click(function(){
	        document.location = '<?php echo url_for('politico/take?op=c&id='.$politico->getId()) ?>';
		});	
  });
  //-->
</script>

<div id="content">
  <h2><?php echo __('Importante: antes de seguir haciendo clicks se hace saber...') ?></h2>

  <p><?php echo __('Si estás intentando suplantar la personalidad de un político recuerda que eres responsable de las consecuencias que esto pueda tener.')?></p>

  <div class="actions">
    <?php // TODO: cambiar enlace para que apunte a la página del político ?>
    <div class="cancel"><a href="<?php echo url_for('politico/show?id='.$politico->getVanity()) ?>"><?php echo __('Volver, sólo quería curiosear') ?></a></div>
    <?php // TODO: cambiar botón para que apunte a la página de takeConfirm ?>
    <div class="submit"><button id="take_confirm_button"><?php echo __('Soy consciente, continuar')?></button></div>
  </div>
</div>
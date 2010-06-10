<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php // TODO: La variable $entity contiene el político, partido o propuesta ?>

<script type="text/javascript">
  $(document).ready(function(){
  	$("#nueva-etiqueta-ac").autocomplete({
  		source: '<?php echo url_for('politico/acPartido')?>', // TODO: Cambiar URL por la de consulta de etiquetas
  		select: function(event, ui) {
  		  $("#nueva-etiqueta").val(ui.item.id);
  		  $("#nueva-etiqueta").closest('form').submit(); // TODO: Quizás interese cambiar por una llamada Ajax, y refrescar sólo esta caja
  		}
  	});
  })
</script>

<h3><?php echo __('También conocido como...') ?></h3>

<?php if (true): // TODO: Si está logueado ?>
  <form id="ac-nueva-etiqueta-frm" action="#"><?php // TODO: Rellenar acción con URL de nueva etiqueta ?>
    <input type="hidden" name="e" id="nueva-etiqueta" value="" />
    <p>
    	<input type="text" id="nueva-etiqueta-ac" value="" title="<?php echo __('Tú dirás...')?>" />
    </p>
  </form>
<?php else: ?>
  <p><a href=""><?php echo __('(Entrar en Voota para etiquetar)') ?></a><?php // TODO: Enlazar a login ?></p>
<?php endif ?>

<?php if (true): // TODO: Si hay etiquetas ?>
  <ul>
    <?php foreach (array("Desgraciao", "Educado", "Cumplidor") as $etiqueta): // TODO: Cargar etiquetas reales ?>
      <li>
        <a href="#"><?php echo $etiqueta // TODO: Enlazar a página de etiqueta ?></a>
        <?php echo "(2)" // TODO: Contador de apariciones de etiqueta ?>
        <?php if (true): // TODO: Si el usuario actual escribió esta etiqueta ?>
          <a href="" class="remove">X</a> <?php // TODO: Enlazar a eliminación de voto a esa etiqueta del usuario actual ?>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
<?php else: ?>
  <p><?php echo __('Aún no ha sido etiquetado') ?></p>
<?php endif ?>
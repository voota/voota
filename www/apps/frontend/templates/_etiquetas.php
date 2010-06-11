<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php // TODO: La variable $entity contiene el político, partido o propuesta ?>

<script type="text/javascript">
  $(document).ready(function(){

	$("#nueva-etiqueta").closest('form').submit(function(){
		var data = $("#nueva-etiqueta").closest('form').serialize();
  		$.ajax({
    		  type     : 'POST',
    		  dataType : 'html',
    		  data:data,
    		  url      : '<?php echo url_for('politico/newtag')?>',
    		  success  : function(data, textStatus) {
    			  $("#nueva-etiqueta-ac").val('');  
    		  	$('#entity-tags').html(data);
    		  }
    		});
		return false;
	});
	
  	$("#nueva-etiqueta-ac").autocomplete({
  		source: '<?php echo url_for('politico/tags')?>',
  		select: function(event, ui) {
  		  $("#nueva-etiqueta").val(ui.item.id);  
  		}
  	});
  })
</script>

<h3><?php echo __('También conocido como...') ?></h3>

<?php if ($sf_user->isAuthenticated()): ?>
  <form id="ac-nueva-etiqueta-frm" action="#">
    <input type="hidden" name="entity" value="<?php echo $entity->getId() ?>" />
    <input type="hidden" name="e" id="nueva-etiqueta" value="" />
    <p>
    	<input type="text" id="nueva-etiqueta-ac" name="texto" value="" title="<?php echo __('Tú dirás...')?>" />
    </p>
  </form>
<?php else: ?>
  <p><a href="<?php echo url_for('sfGuardAuth/signin')?>"><?php echo __('(Entrar en Voota para etiquetar)') ?></a></p>
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
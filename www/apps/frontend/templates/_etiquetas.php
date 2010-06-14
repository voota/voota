<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

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
    			re_loading( 'taglist' );
    		  	$('#taglist').html(data);
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
  
  function removeTag( id ){
  	$.ajax({
    	  type     : 'POST',
    	  dataType : 'html',
    	  data	   : 'e=<?php echo $entity->getId() ?>&id='+id,
    	  url      : '<?php echo url_for('politico/rmtag')?>',
    	  success  : function(data, textStatus) {
    		re_loading( 'taglist' );
    	  	$('#taglist').html(data);
    	  }
    	});
	return false;
  }
</script>

<h3><?php echo __('También conocido como...') ?></h3>

<?php if ($sf_user->isAuthenticated()): ?>
  <form id="ac-nueva-etiqueta-frm" action="#">
    <input type="hidden" name="entity" value="<?php echo $entity->getId() ?>" />
    <input type="hidden" name="e" id="nueva-etiqueta" value="" />
    <p>
    	<input type="text" id="nueva-etiqueta-ac" name="texto" value="" title="<?php echo __('Tú dirás...')?>" />
    	<input type="submit" id="nueva-etiqueta-submit" value="+" />
    </p>
  </form>
<?php else: ?>
  <p><a href="<?php echo url_for('sfGuardAuth/signin')?>"><?php echo __('(Entrar en Voota para etiquetar)') ?></a></p>
<?php endif ?>

<div id="taglist">
	<?php include_component_slot('tags', array('entity' => $entity)) ?>
</div>

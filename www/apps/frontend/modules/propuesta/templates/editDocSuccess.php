<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('.confirm_delete').click(function(){
			re_loading( 'ed_box' );
			jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#ed_box').html(data);},url:'<?php echo url_for('propuesta/editDoc?op=f&id='.$propuesta->getId())?>'});
			$('#fileName').html('<?php echo __('ninguno')?>');
			return false;
	  });
	  $('.cancel_delete').click(function(){
	    $('#ed_box').hide();
	  });
  });
  //-->
</script>

<?php echo $propuesta->getDoc() ?>

<?php // TODO: Sustituir por enlace a documento adjunto ?>
<a class="doc-link" href="#">Normas_Generales.pdf</a>
<a href="#" class="confirm_delete"><?php echo __('Borrar para añadir uno nuevo')?></a>
<a href="#" class="confirm_delete"><?php echo __('Sí')?></a>
<a href="#" class="cancel_delete"><?php echo __('No')?></a>
<a href="#" class="cancel_delete" id="close_ed_box"><?php echo __('(Cerrar)')?></a>
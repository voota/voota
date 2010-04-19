<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#confirm_delete').click(function(){
			re_loading( 'ed_box' );
			jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#ed_box').html(data);},url:'<?php echo url_for('propuesta/editDoc?op=f&id='.$propuesta->getId())?>'});
			$('#fileName').html('<?php echo __('ninguno')?>');
			return false;
	  });
  });
  //-->
</script>
<?php echo $propuesta->getDoc() ?>

<?php echo __('Borrar para añadir uno nuevo')?> 

<a href="#" id="confirm_delete"><?php echo __('Sí')?></a>
<a href="#"><?php echo __('No')?></a>
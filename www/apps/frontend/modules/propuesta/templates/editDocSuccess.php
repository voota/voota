<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#docbox .confirm_delete').click(function(){
			re_loading( 'edit-doc-box' );
			jQuery.ajax({type:'POST',dataType:'html',success:function(data, textStatus){jQuery('#edit-doc-box').html(data);},url:'<?php echo url_for('propuesta/editDoc?op=f&id='.$propuesta->getId())?>'});
			$('#fileName').html('<?php echo __('ninguno')?>');
			return false;
	  });
	  $('#docbox .cancel_delete').click(function(){
	    $('#edit-doc-box').hide();
	  });
  });
  //-->
</script>

<?php if($propuesta->getDoc()): ?>
	<a class="doc-link"  href="<?php echo S3Voota::getImagesUrl().'/docs/'.$propuesta->getDoc() ?>">
	<?php echo $propuesta->getDoc() ?>
	</a>
<?php endif ?>

<a href="#" class="confirm_delete"><?php echo $propuesta->getDoc()?__('Borrar para añadir uno nuevo'):__('Adjuntar documento a la propuesta')?></a>
<a href="#" class="confirm_delete"><?php echo __('Sí')?></a>
<a href="#" class="cancel_delete"><?php echo __('No')?></a>
<a href="#" class="cancel_delete close-edit-box" id="close-edit-doc-box"><?php echo __('(Cerrar)')?></a>
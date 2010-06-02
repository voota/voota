<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript" charset="utf-8">
  <!--//
  		$(document).ready(function() {
  		  $('#docbox .cancel_delete').click(function(){
    	    $('#edit-doc-box').hide();
    	  });
  	  		/*

		*/
		var upload = new AjaxUpload('doc', {
				action: '<?php echo url_for('propuesta/editDoc?op=u&id='.$propuesta->getId()) ?>'
				, name: 'doc'
				, autoSubmit: false			
				, onChange: function(file, response) {
					$('#file_name').html( file );
				}		
				, onComplete: function(file, response) {
					if (response == '0'){
						re_loading( 'docbox' );
						jQuery.ajax({type:'POST',dataType:'html',data:jQuery(this).serialize(),success:function(data, textStatus){jQuery('#docbox').html(data);},url:'<?php echo url_for('propuesta/editDoc?op=s&id='.$propuesta->getId())?>'});
						//location.reload(true);
					}
				}
			});

		
		$('#edit-doc-form').submit(function(){
			re_loading( 'edit-doc-box' );
			upload.submit();
			return false;
	  	});
  });
  //-->
</script>

<h4><?php echo __('Añadir nuevo documento')?></h4>

<p><?php echo __('PDF, Office, OpenOffice... (Máx 2Mb)')?></p>

<form method="post" id="edit-doc-form" enctype="multipart/form-data" action="<?php echo url_for('propuesta/editDoc?id='.$propuesta->getId()) ?>">
	<div><input type="hidden" name="op" value="a" /></div>
  <p><input type="file" name="doc" id="doc" /></p>
  <div id="file_name"></div>
  <p><input type="submit" value="<?php echo __('Guardar')?>" /></p>
</form>

<a href="#" class="cancel_delete close-edit-box" id="close-edit-doc-box"><?php echo __('(Cerrar)')?></a>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script type="text/javascript" charset="utf-8">
  <!--//
  		$(document).ready(function() {
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
						location.reload(true);
					}
				}		
			});

		
		$('#ed_form').submit(function(){
			re_loading( 'ed_box' );
			upload.submit();
			return false;
	  	});
  });
  //-->
</script>

<?php echo __('Añadir nuevo documento')?> 

<form method="post" id="ed_form" enctype="multipart/form-data" action="<?php echo url_for('propuesta/editDoc?id='.$propuesta->getId()) ?>">
	<input type="hidden" name="op" value="a" />
      <table>
        <tr>
          <td>
            <input type="file" name="doc" id="doc" />
            <div id="file_name"></div>
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" value="<?php echo __('Guardar')?>" />
          </td>
        </tr>
        </table>

</form>
<?php use_helper('I18N') ?>

<script type="text/javascript">
  <!--
  $(document).ready(function(){
	  $('#oauth_authorize_button').click(function(){
		  $('#oauth_authorize_field').val( 1 );
		  return true;
	  });
  });
  //-->
</script>

<p><?php echo __('La aplicación solicita acceso a tu cuenta en Voota.') ?></p>
<p><?php echo __('Autorizando esto, la aplicación podrá acceder a tus datos y dejar opiniones en tu nombre.') ?></p>

<?php if ($oauth_token):?>
<p><?php echo __('¿Das tu permiso?') ?></p>
<form method="post">
	<input type="hidden" name="oauth_token" value="<?php echo $oauth_token ?>" />
	<input type="hidden" name="oauth_callback" value="<?php echo $oauth_callback ?>" />
	<input type="hidden" name="authorized" value="1" id="oauth_authorize_field" />
	<input type="submit" value="<?php echo __('Autorizar') ?>" id="oauth_authorize_button" />
	<input type="submit" value="<?php echo __('Denegar') ?>" />
</form>
<?php else:?>
<p><?php echo __('Error: Es necesario un token (oauth_token).') ?></p>
<?php endif?>

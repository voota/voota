<?php if ($box == 'lo_fb_conn'): ?>
	<script type="text/javascript">
	<!--
		document.location = '<?php echo url_for("@usuario_edit#facebook-connect");?>';
	//-->
	</script>
<?php else: ?>
	<div id="fb_confirm_box">
	<?php use_helper('I18N') ?>
	  <h3>
	    <img src="/images/icoFacebook.png" alt="Facebook Connect" />
	    <?php echo __('Conectado a Facebook como:') ?>
	    <strong><fb:name uid="<?php echo $faceBookUid ?>" useyou="false" linked="false"></fb:name></strong>
	  </h3>
	<p>
	<?php echo __('Ojo, ahora tienes otra cuenta asociada a tu perfil de Facebook. Unificando las dos todo será más sencillo. ¿Cómo lo ves?')?>
	</p>
	<form action="#">
		<input onclick="return facebookConnect_loadPreferences('<?php echo url_for('@usuario_fb_confirm_merge') ?>', 'fb_confirm_box');" type="submit" value="Ok, unificar cuentas">
	</form>
	</div>
<?php endif ?>
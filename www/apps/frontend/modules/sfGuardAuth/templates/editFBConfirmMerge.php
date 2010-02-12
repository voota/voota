<?php use_helper('I18N') ?>
  <h3>
    <img src="/images/icoFacebook.png" alt="Facebook Connect" />
    <?php echo __('Conectado a Facebook como:') ?>
    <strong><fb:name uid="<?php echo $faceBookUid ?>" useyou="false" linked="false"></fb:name></strong>
  </h3>
<p>
<?php echo __('Ojo tienes una cuenta en Voota y otra en Facebook. Unificando las dos cuentas todo será más sencillo. ¿Cómo lo ves?')?>
</p>
<form action="#">
	<input onclick="return facebookConnect_loadPreferences('<?php echo url_for('@usuario_fb_confirm_merge') ?>');" type="submit" value="Ok, unificar cuentas">
</form>
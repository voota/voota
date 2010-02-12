<?php use_helper('I18N') ?>
  <h3>
    <img src="/images/icoFacebook.png" alt="Facebook Connect" />
    <?php echo __('Conectado a Facebook como:') ?> 
    <fb:profile-pic uid="<?php echo $faceBookUid ?>" useyou="false" linked="false" size="square" facebook-logo="true" width="36" height="36"></fb:profile-pic>
    <strong><fb:name uid="<?php echo $faceBookUid ?>" useyou="false" linked="false"></fb:name></strong>
  </h3>
<p>
Vamos a vincular tu cuenta Voota <?php $sfuser ?> con tu cuenta Facebook <fb:name uid="<?php echo $faceBookUid ?>" useyou="false" linked="false"></fb:name>,
¿Vale?
</p>
<form action="#">
	<input onclick="return facebookConnect_loadPreferences('<?php echo url_for('@usuario_fb_confirm_merge') ?>');" type="submit" value="Adelante!">
</form>
<a onclick="return facebookConnect_loadPreferences('<?php echo url_for('@usuario_fb_edit') ?>');" href="#">Cancelar, no vincular cuentas</a>
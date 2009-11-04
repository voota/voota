<?php use_helper('I18N') ?>
<?php echo __('<p>¡Hola %1%!</p>
<p> Alguien, seguramente tú, nos ha solicitado que te enviemos la contraseña que has olvidado. En el siguiente enlace podrás configurar dicha contraseña a tu gusto:</p>
<p>', array('%1%' => $nombre)) ?>



<?php echo link_to(
				url_for("@usuario_change_password?codigo=$codigo", true), 
				"@usuario_change_password?codigo=$codigo", 
				'absolute=true',
				array('style'  => 'color:#2b56ff; font-weight: normal')
			) ?>

<?php echo __('</p>

<p>Si no puedes pinchar sobre el enlace, cópialo y pégalo en la barra de dirección de tu navegador.</p>
<p>Si no has sido tú quien ha solicitado el envío de tu contraseña, te pedimos disculpas. Nada ni nadie va acceder a tu cuenta, no te preocupes. Simplemente borra y olvida este email.</p>
<p>&nbsp;</p>
<p>Un saludo</p>
<p>Comunidad Voota</p>') ?>
          
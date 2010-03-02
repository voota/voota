<?php use_helper('I18N') ?>

<?php echo __('<p>¡Hola %nombrePolitico%!</p>
<p>En primer lugar, queremos darte las gracias por animarte a participar como político en Voota. Nos hace mucha ilusión tenerte entre nosotros, de verdad.</p>

<p>A partir de ahora podrás:</p>
<ul>
<li>Editar la información que aparece en tu perfil (fotografía, bio, enlaces externos, etc.).</li>
<li>Responder a las opiniones que otros usuarios hacen sobre ti.</li>
<li>Recibir notificaciones cuando tienes una nueva opinión.</li>
</ul>

<p>Esta es tu página de usuario en Voota:  %urlUsuario%</p>

<p>Esta es tu página de político en Voota:  %urlPolitico%</p>

<p>Si quieres volver al pasado, escríbenos y todo volverá a su situación inicial:  http://www.voota.es/contactar</p>

<p>Esperamos serte útiles.</p>

<p>Un abrazo, Comunidad Voota</p>

<p>Voota es una web que sirve para compartir opiniones sobre los políticos de España,</p>



<p>Nuestra web:  http://voota.es/es</p>
<p>Blog de Voota:  http://blog.voota.es</p>
<p>Voota en Twitter:  http://twitter.com/voota</p>
<p>Voota en Facebook:  http://facebook.com/voota</p>
', array(
		'%nombrePolitico%' => $nombrePolitico
		, '%nombreUsuario%' => $nombreUsuario
		, '%urlUsuario%' => url_for("perfil/show?username=$vanityUsuario", true)
		, '%urlPolitico%' => url_for("politico/show?id=$vanityPolitico", true)
		)
) ?>

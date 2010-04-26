<?php use_helper('I18N') ?>

<?php echo __('<p>¡Hola %nombrePolitico%!</p>
<p>Queremos avisarte que a partir de ahora %nombreUsuario% podrá hacer cambios sobre tu perfil (biografía, fotografía, enlaces externos, etc.) y responder a las opiniones de otros usuarios sobre tu actividad política.</p>

<p>Este es el perfil de %nombreUsuario% en Voota:  %urlUsuario%</p>

<p>Esta es tu nueva página en Voota: %urlPolitico%</p>

<p>Si crees que este usuario está intentando usurpar tu identidad ponte en contacto con nosotros. Estaremos encantados de darte a ti el control sobre tu perfil: http://voota.es/contact</p>

<p>Un saludo, Comunidad Voota</p>

<p>--</p>
<p>Voota es una web que sirve para compartir opiniones sobre los políticos de España.</p>
<p>Nuestra web:  http://voota.es</p>
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

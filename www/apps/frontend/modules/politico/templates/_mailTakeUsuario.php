<?php use_helper('I18N') ?>

<?php echo __('
  <p>¡Hola %nombrePolitico%!</p>
  <p>En primer lugar, queremos darte las gracias por animarte a participar como político en Voota. Nos hace mucha ilusión tenerte entre nosotros, de verdad.</p>
  <p>A partir de ahora podrás:</p>
  <ul>
    <li>Editar la información que aparece en tu perfil (fotografía, bio, enlaces externos, etc.).</li>
    <li>Responder a las opiniones que otros usuarios hacen sobre ti.</li>
    <li>Recibir notificaciones cuando tienes una nueva opinión.</li>
  </ul>
  <p>Esta es tu página de usuario en Voota:  %urlUsuario%</p>
  <p>Esta es tu página de político en Voota:  %urlPolitico%</p>
  <p>Si quieres volver al pasado, escríbenos y todo volverá a su situación inicial: http://voota.es/contact</p>
  <p>Esperamos serte útiles.</p>',
  array(
		'%nombrePolitico%' => $nombrePolitico,
		'%nombreUsuario%'  => $nombreUsuario,
		'%urlUsuario%'     => url_for("perfil/show?username=$vanityUsuario", true),
		'%urlPolitico%'    => url_for("politico/show?id=$vanityPolitico", true)
	)
) ?>

<?php include_partial('global/mailFooter') ?>
<?php use_helper('I18N') ?>

<?php echo __('
  <p>Hola %1%</p>
  <p>%2% acaba de dejarte un mensaje tras pasar por tu perfil. Esto es lo que te dice: "%3%"</p>
  <p>Visita el perfil de %2%: <a href="%4%">%4%</a></p>
  <p>Dejar de recibir estos avisos (simplemente pincha en este link): <a href="%5%">%5%</a></p>',
  array(
    '%1%' => $destinatario,
    '%2%' => $remitente,
    '%3%' => $cuerpo,
    '%4%' => url_for("@usuario?username=$vanity", true),
    '%5%' => url_for("@usuario_unsubscribe?codigo=$codigo&n=2", true)
  )
) ?>

<?php include_partial('global/mailFooter') ?>
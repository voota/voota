<?php use_helper('I18N') ?>
<?php echo __('<p>Hola %1%</p>
<p>%2% acaba de dejarte un mensaje tras pasar por tu perfil. Esto es lo que te dice: "%3%"</p>
<p>Visita el perfil de %2%: <a href="%4%">%4%</a></p>
<p>Dejar de recibir estos avisos (simplemente pincha en este link): <a href="%5%">%5%</a></p>
<p>Un abrazo,</p>
<p>Comunidad Voota</p>
<p>
  Nuestra web: <a href="http://voota.es/es">http://voota.es/es</a><br />
  Blog de Voota: <a href="http://blog.voota.es">http://blog.voota.es</a><br />
  Voota en Twitter: <a href="http://twitter.com/voota">http://twitter.com/voota</a><br />
  Voota en Facebook: <a href="http://facebook.com/voota">http://facebook.com/voota</a><br />
</p>'
, array('%1%' => $remitente,
        '%2%' => $destinatario,
        '%3%' => $cuerpo,
        '%4%' => $url_perfil,
        '%5%' => $url_desuscribir)) ?>
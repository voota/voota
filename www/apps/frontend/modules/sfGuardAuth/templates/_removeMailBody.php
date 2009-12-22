<?php use_helper('I18N') ?>

<?php echo __('<p>Hola %1%,</p>

<p>Alguien, seguramente tú, ha solicitado darse de baja en la web <a href="http://www.voota.es/">Voota.es</a>.</p>

<p>Antes de borrarte nos gustaría que nos lo confirmases para asegurarnos de que eres tú el que ha solicitado dicha baja. Para ello tan sólo tienes que pinchar sobre el siguiente link:</p>') ?>

<?php
  echo '<p>';
  echo link_to('#', '#');
  echo '<br />';
  echo __('Si no puedes pinchar sobre el enlace, cópialo y pégalo en la barra de dirección de tu navegador.');
  echo '</p>';
 ?>

<?php echo __('<p>Si no has sido tú quien ha solicitado darse de baja en Voota, te pedimos disculpas. Nada ni nadie va a acceder a tu cuenta, no te preocupes. Simplemente borra y olvida este email.</p>

<p>&nbsp;</p>

<p>Un abrazo, Comunidad Voota</p>

<p>
  Nuestra web: <a href="http://voota.es/es">http://voota.es/es</a><br />
  Blog de Voota: <a href="http://blog.voota.es">http://blog.voota.es</a><br />
  Voota en Twitter: <a href="http://twitter.com/voota">http://twitter.com/voota</a><br />
  Voota en Facebook: <a href="http://facebook.com/voota">http://facebook.com/voota</a><br />
</p>') ?>
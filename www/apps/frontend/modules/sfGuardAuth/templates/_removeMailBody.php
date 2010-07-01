<?php use_helper('I18N') ?>

<?php echo __('
  <p>Hola %1%,</p>
  <p>Alguien, seguramente tú, ha solicitado darse de baja en la web <a href="http://voota.es/">Voota.es</a>.</p>
  <p>Antes de borrarte nos gustaría que nos lo confirmases para asegurarnos de que eres tú el que ha solicitado dicha baja. Para ello tan sólo tienes que pinchar sobre el siguiente link:</p>
  <p>
    %2%
    <br />
    Si no puedes pinchar sobre el enlace, cópialo y pégalo en la barra de dirección de tu navegador.
  </p>
  <p>Si no has sido tú quien ha solicitado darse de baja en Voota, te pedimos disculpas. Nada ni nadie va a acceder a tu cuenta, no te preocupes. Simplemente borra y olvida este email.</p>',
  array(
    '%1%' => $nombre,
    '%2%' => link_to( url_for("@usuario_remove_confirm?codigo=$codigo", true), 
                      "@usuario_remove_confirm?codigo=$codigo", 
    				          'absolute=true',
    				          array('style' => 'color:#2b56ff; font-weight: normal') )
  )
) ?>

<?php include_partial('global/mailFooter') ?>
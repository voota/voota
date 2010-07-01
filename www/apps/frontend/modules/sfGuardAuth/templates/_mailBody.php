<?php use_helper('I18N') ?>

<?php echo __('
  <p>¡Hola %1%!</p>
  <p>Dos simples frases para comentarte que para terminar tu registro en Voota necesitamos que nos confirmes que eres tú. Tan sólo tienes que pinchar sobre el siguiente enlace:</p>
  <p>%2</p>
  <p>Si no puedes pinchar sobre el enlace cópialo y pégalo en la barra de dirección de tu navegador.</p>
  <p>¡Y nada más! Te damos la bienvenida a Voota ;-)</p>',
  array(
    '%1%' => $nombre,
    '%2%' => link_to( url_for("@usuario_confirm?codigo=$codigo", true), 
    	                "@usuario_confirm?codigo=$codigo", 
    	                'absolute=true',
                      array('style' => 'color:#2b56ff; font-weight: normal') )
  )
) ?>

<?php include_partial('global/mailFooter') ?>
<?php use_helper('I18N') ?>

<p><?php echo __('La aplicación se ha registrado correctamente con estos datos. En breve recibirás una copia por email. Mientras tanto pudes tomar nota de las claves.')?></p>


<div class="oauth_keys">
	<div class="oauth_label">consumer_id:</div>
	<div class="oauth_data"><?php echo $consumer['id']?>&nbsp;</div>
	<div class="oauth_label">consumer_key:</div>
	<div class="oauth_data"><?php echo $consumer['consumer_key']?>&nbsp;</div>
	<div class="oauth_label">consumer_secret:</div>
	<div class="oauth_data"><?php echo $consumer['consumer_secret'] ?>&nbsp;</div>
</div>

<div>
	<div class="oauth_label"><?php echo __('Tu nombre')?>:</div>
	<div><?php echo $consumer['requester_name']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Tu email')?>:</div>
	<div><?php echo $consumer['requester_email']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Dirección de callback')?>:</div>
	<div><?php echo $consumer['callback_uri']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Web de la aplicación')?>:</div>
	<div><?php echo $consumer['application_uri']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Título')?>:</div>
	<div><?php echo $consumer['application_title']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Descripción')?>:</div>
	<div><?php echo $consumer['application_descr']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Notas')?>:</div>
	<div><?php echo $consumer['application_notes']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('Tipo')?>:</div>
	<div><?php echo $consumer['application_type']?>&nbsp;</div>
	<div class="oauth_label"><?php echo __('¿Es comercial?')?>:</div>
	<div><?php echo $consumer['application_commercial'] == 1?__('Sí'):__('No')?></div>
</div>

<div class="oauth_notice">
<p><?php echo __('Para más información sobre como utilizar nuestro API, visita <a href="http://trac.voota.org/wiki/API">http://trac.voota.org/wiki/API</a> (en inglés, sorry)')?></p>
</div>
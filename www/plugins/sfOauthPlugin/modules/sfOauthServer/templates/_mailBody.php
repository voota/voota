<?php use_helper('I18N') ?>

<p><?php echo __('Hola %nombre%, ', array('%nombre%' => $nombre))?></p>

<p><?php echo __('Estos son los datos de la apliación que acabas de registrar')?></p>


<table>
<tr>
	<td>consumer_id:</td>
	<td><strong><?php echo $consumer['id']?></strong></td>
</tr>
<tr>
	<td>consumer_key:</td>
	<td><strong><?php echo $consumer['consumer_key']?></strong></td>
</tr>
<tr>
	<td>consumer_secret:</td>
	<td><strong><?php echo $consumer['consumer_secret']?></strong></td>
</tr>
</table>

<table>
<tr>
	<td><?php echo __('Dirección de callback')?>:</td>
	<td><?php echo $consumer['callback_uri']?></td>
</tr>
<tr>
	<td><?php echo __('Web de la aplicación')?>:</td>
	<td><?php echo $consumer['application_uri']?></td>
</tr>
<tr>
	<td><?php echo __('Título')?>:</td>
	<td><?php echo $consumer['application_title']?></td>
</tr>
<tr>
	<td><?php echo __('Descripción')?>:</td>
	<td><?php echo $consumer['application_descr']?></td>
</tr>
<tr>
	<td><?php echo __('Notas')?>:</td>
	<td><?php echo $consumer['application_notes']?></td>
</tr>
<tr>
	<td><?php echo __('Tipo')?>:</td>
	<td><?php echo $consumer['application_type']?></td>
</tr>
<tr>
	<td><?php echo __('¿Es comercial?')?>:</td>
	<td><?php echo $consumer['application_commercial'] == 1?__('Sí'):__('No')?></td>
</tr>
</table>

<div class="oauth_notice">
<p><?php echo __('Para más información sobre como utilizar nuestro API, visita <a href="http://trac.voota.org/wiki/API">http://trac.voota.org/wiki/API</a> (en inglés, sorry)')?></p>
</div>
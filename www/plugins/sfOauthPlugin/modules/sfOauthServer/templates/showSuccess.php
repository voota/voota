<table>
	<tr>
		<td>id:</td>
		<td><?php echo $consumer_id?></td>
	</tr>
	<tr>
		<td>key:</td>
		<td><?php echo $consumer_key?></td>
	</tr>
	<tr>
		<td>secret:</td>
		<td><?php echo $consumer_secret?></td>
	</tr>
</table>

<ul>
<?php foreach($list as $customer ):?>
	<li><pre><?php var_dump($customer) ?></pre></li>
<?php endforeach ?>
</ul>
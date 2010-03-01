
<?php 
$politico = $form->getObject();
if ($politico->getSfGuardUser()):
?>
	<p>
	<?php echo link_to($politico->getSfGuardUser()->getProfile()->getNombreOri().' '.$politico->getSfGuardUser()->getProfile()->getApellidosOri(), "sfGuardUser/edit?id=".$politico->getSfGuardUser()->getId()) ?> 
	(<a href="<?php url_for('politico/edit?id='.$politico->getId())?>?op=rmusr" onclick="return confirm('sure?');">desconectar</a>)
	</p>
<?php else: ?>
	<p>No tiene usuario asociado</p>
<?php endif ?>


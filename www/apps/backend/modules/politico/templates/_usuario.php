<?php 
if ($politico->getSfGuardUser()){
?>
	<?php echo link_to($politico->getSfGuardUser()->getProfile()->getNombreOri().' '.$politico->getSfGuardUser()->getProfile()->getApellidosOri(), "sfGuardUser/edit?id=".$politico->getSfGuardUser()->getId()) ?>
<?php 
}
?>


<?php 
if ($politico->getSfGuardUser()){
?>
	<?php echo link_to($politico->getSfGuardUser(), "sfGuardUser/edit?id=".$politico->getSfGuardUser()->getId()) ?>
<?php 
}
?>


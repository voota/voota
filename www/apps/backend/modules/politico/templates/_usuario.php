<?php 
if ($politico->getSfGuardUserProfile()){
	echo $politico->getSfGuardUserProfile()->getEmail();
}
// echo link_to($politico->getUsuario()->getEmail(), 'usuario/'. $politico->getUsuario()->getId(), "/edit") 
?>


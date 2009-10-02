<?php 
if ($politico->getSfGuardUserProfile()){
	echo $politico->getSfGuardUserProfile()->getSfGuardUser->getUsername();
}
// echo link_to($politico->getUsuario()->getEmail(), 'usuario/'. $politico->getUsuario()->getId(), "/edit") 
?>


<?php 
if ($politico->getUsuario()){
	echo $politico->getUsuario()->getEmail();
}
// echo link_to($politico->getUsuario()->getEmail(), 'usuario/'. $politico->getUsuario()->getId(), "/edit") 
?>


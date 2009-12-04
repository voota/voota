<?php use_helper('VoFormat') ?>
<?php 
if ($form->getObject()->getBio('es')){
	echo formatBio( $form->getObject()->getBio('es') );
}
// echo link_to($politico->getUsuario()->getEmail(), 'usuario/'. $politico->getUsuario()->getId(), "/edit") ?>

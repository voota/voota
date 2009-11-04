<?php use_helper('VoFormat') ?>
<?php 
if ($form->getObject()->getBio()){
	echo formatBio( $form->getObject()->getBio() );
}
// echo link_to($politico->getUsuario()->getEmail(), 'usuario/'. $politico->getUsuario()->getId(), "/edit") ?>

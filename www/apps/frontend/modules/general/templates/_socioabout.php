<?php use_helper('SfReview') ?>

<div class="aboutContainer">
<div class="aboutFoto">
	<?php echo image_tag(
		'http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($socio->getProfile()->getImagen()), 'alt="Foto '. $socio->getProfile()->getNombre().' ' . $socio->getProfile()->getApellidos() .' (Voota)"') ?>
</div>
  <div class="aboutTexto"><h6><strong><?php echo $socio->getProfile()->getNombre()?> <?php echo $socio->getProfile()->getApellidos()?> · <?php echo $socio->getProfile()->getPapelVoota()?></strong>    <br>
    <?php $presentacion = $socio->getProfile()->getPresentacion(); autolink($presentacion, false) ?>
    <?php echo $presentacion ?>
  </h6></div>
</div>
<div class="limpiar"></div>

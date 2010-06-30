<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<li>
  <div class="avatar">
	  <?php //echo image_tag(S3Voota::getImagesUrl().'/usuarios/cc_s_'.($socio->getProfile()->getImagen()), 'alt="'. __('Foto de %1%', array('%1%' => $socio->getProfile()->getNombre().' ' . $socio->getProfile()->getApellidos() .' (Voota)')) .'"') ?>
	  <?php echo getAvatar( $socio ) ?>
  </div>
  <h4 class="name"><?php echo link_to($socio, "@usuario?username=".$socio->getProfile()->getVanity()) ?> · <?php echo $socio->getProfile()->getPapelVoota()?></h4>
  <p class="body">
    <?php $presentacion = $socio->getProfile()->getPresentacion(); autolink($presentacion, false) ?>
    <?php echo $presentacion ?>
  </p>
</li>
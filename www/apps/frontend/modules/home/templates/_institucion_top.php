<li>
	<div class="avatar">
	  <?php if($institucion->getImagen()!=''): ?>
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/instituciones/cc_s_'.($institucion->getImagen()!=''?$institucion->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $institucion)) .'"') ?>
	  <?php endif ?>
    </div>
	<h4 class="name"><?php echo link_to($institucion->getNombre(), 'politico/ranking?partido=all&institucion='.$institucion->getVanity())?></h4>
</li>

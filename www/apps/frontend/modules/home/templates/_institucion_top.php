<li>
	<div class="avatar">
	  <?php if($institucion->getImagen()!=''): ?>
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/instituciones/'.($institucion->getImagen()!=''?$institucion->getImagen():'p_unknown.png'), 'alt="Foto de '. $institucion .'"') ?>
	  <?php endif ?>
    </div>
	<h4 class="name"><?php echo link_to($institucion->getNombre(), 'politico/ranking?institucion='.$institucion->getVanity())?></h4>
</li>

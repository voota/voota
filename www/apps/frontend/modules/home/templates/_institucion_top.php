<li>
	<div class="avatar">
    	<?php echo image_tag(S3Voota::getImagesUrl().'/instituciones/cc_s_'.($institucion['imagen']!=''?$institucion['imagen']:'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $institucion['nombre'])) .'"') ?>
    </div>
	<h4 class="name"><?php echo link_to($institucion['nombre'], 'politico/ranking?partido=all&institucion='.$institucion['vanity'])?></h4>
</li>

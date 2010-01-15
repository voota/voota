<li>
	<div class="avatar">
	  <?php if($partido->getImagen()!=''): ?>
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/cc_s_'.($partido->getImagen()!=''?$partido->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $partido)) .'"') ?>
	  <?php endif ?>
    </div>
	<h4 class="name"><?php echo link_to($partido->getNombre()." (".$partido->getAbreviatura().")", 'partido/show?id='.$partido->getAbreviatura())?></h4>
</li>

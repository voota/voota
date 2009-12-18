<li>
	<div class="avatar">
	  <?php if($partido->getImagen()!=''): ?>
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/cc_s_'.($partido->getImagen()!=''?$partido->getImagen():'p_unknown.png'), 'alt="Foto de '. $partido .'"') ?>
	  <?php endif ?>
    </div>
	<h4 class="name"><?php echo link_to($partido->getNombre()." (".$partido->getAbreviatura().")", 'politico/ranking?partido='.$partido->getAbreviatura())?></h4>
</li>

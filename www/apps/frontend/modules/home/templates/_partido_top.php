<li>
	<div class="avatar">
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/cc_s_'.($partido->getImagen()!=''?$partido->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $partido)) .'"') ?>
    </div>
	<h4 class="name"><?php echo link_to($partido->getNombre()." (".$partido->getAbreviatura().")", 'partido/show?id='.$partido->getAbreviatura())?></h4>
   <p class="votes">
  		<?php include_partial('partido/sparkline_box', array('partido' => $partido, 'prefix' => 'sparkline_tp_')) ?>
		<span class="votes-count">
				<?php if ($partido->getSumu() > 0 && $partido->getSumd() > 0): ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => $partido->getSumu()),$partido->getSumu())) ?>
					<?php // echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => $partido->getSumd()), $partido->getSumd())) ?>
				<?php elseif ($partido->getSumu() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $partido->getSumu()), $partido->getSumu()) ?>				
				<?php elseif ($partido->getSumd() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto negativo|(1,+Inf]%1% votos negativos', array('%1%' => $partido->getSumd()), $partido->getSumd()) ?>				
				<?php endif?>  
		</span>
	</p>
</li>

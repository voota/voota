<li>
	<div class="avatar">
    	<?php echo link_to(image_tag(S3Voota::getImagesUrl().'/partidos/cc_s_'.($partido->getImagen()!=''?$partido->getImagen():'p_unknown.png'), 'width="36" height="36" alt="'. __('Foto de %1%', array('%1%' => $partido)) .'"'), 'partido/show?id='.$partido->getAbreviatura()) ?>
    </div>
	<h4 class="name"><?php echo link_to($partido->getNombre()." (".$partido->getAbreviatura().")", 'partido/show?id='.$partido->getAbreviatura())?></h4>
  <div class="votes">
		<?php include_partial('general/sparkline_box', array('reviewable' => $partido, 'id' => 'sparkline_tp_'.$partido->getId())) ?>
		<span class="votes-count">
				<?php if (sumu($partido) > 0 && sumd($partido) > 0): ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => sumu($partido)),sumu($partido))) ?>
					<?php // echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => sumd($partido)), sumd($partido))) ?>
				<?php elseif (sumu($partido) > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => sumu($partido)), sumu($partido)) ?>				
				<?php elseif (sumd($partido) > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 negativo|(1,+Inf]%1% negativos', array('%1%' => sumd($partido)), sumd($partido)) ?>				
				<?php endif?>  
		</span>
	</div>
</li>

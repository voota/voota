<?php // TODO: Sustituir variables que hacen referencia a partido por propuesta ?>
<li>
	<div class="avatar">
	  <?php // TODO: Sustituir por imagen reducida de la propuesta ?>
  	<?php echo image_tag(S3Voota::getImagesUrl().'/propuestas/cc_s_'.($p->getImagen()!=''?$p->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $p)) .'"') ?>
  </div>
	<h4 class="name">
	  <?php // TODO: Sustituir por título de la propuesta ?>
	  <?php echo link_to($p->getTitulo(), 'propuesta/show?id='.$p->getVanity())?>
	</h4>
  <div class="votes">
		<?php include_partial('general/sparkline_box', array('reviewable' => $p, 'id' => 'sparkline_tpr_'.$p->getId())) ?>
		<span class="votes-count">
				<?php if (sumu($p) > 0 && sumd($p) > 0): ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => sumu($p)),sumu($p))) ?>
					<?php // echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => sumd($partido)), sumd($partido))) ?>
				<?php elseif (sumu($p) > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => sumu($p)), sumu($p)) ?>				
				<?php elseif (sumd($p) > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 negativo|(1,+Inf]%1% negativos', array('%1%' => sumd($p)), sumd($p)) ?>				
				<?php endif?>  
		</span>
	</div>
</li>

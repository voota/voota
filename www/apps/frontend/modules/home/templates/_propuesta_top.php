<li>
	<div class="avatar">
  	<?php echo link_to(image_tag(S3Voota::getImagesUrl().'/propuestas/cc_s_'.($p->getImagen()!=''?$p->getImagen():'p_unknown.png'), 'width="36" height="36" alt="'. __('Foto de %1%', array('%1%' => $p)) .'"'), 'propuesta/show?id='.$p->getVanity()) ?>
  </div>
	<h4 class="name">
	  <?php echo link_to(sfVoUtil::secureString($p->getTitulo(), "&#39;"), 'propuesta/show?id='.$p->getVanity())?>
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

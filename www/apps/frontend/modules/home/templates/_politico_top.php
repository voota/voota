<?php use_helper('VoFormat') ?>

<li>
	<div class="avatar">
  	<?php echo link_to(image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen(), 'width="36" height="36" alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"'), 'politico/show?id='.$politico->getVanity()) ?>
  </div>
	<h4 class="name"><?php echo link_to(cutToLength("".$politico->getNombre() ." ". $politico->getApellidos(), 26), 'politico/show?id='.$politico->getVanity())?></h4>
  <div class="votes">
    <?php if ($showSparkline): ?>
		  <?php include_partial('general/sparkline_box', array('id' => $id)) ?>
		<?php endif ?>
		<span class="votes-count">
			<?php if (sumu($politico) > 0 && sumd($politico) > 0): ?>
				<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => sumu($politico)),sumu($politico))) ?>
				<?php // echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => $politico->getSumd()), $politico->getSumd())) ?>
			<?php elseif (sumu($politico) > 0): ?>
				<?php echo format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => sumu($politico)), sumu($politico)) ?>				
			<?php elseif (sumd($politico) > 0): ?>
				<?php echo format_number_choice('[0]0|[1]1 negativo|(1,+Inf]%1% negativos', array('%1%' => sumd($politico)), sumd($politico)) ?>				
			<?php endif?>  
		</span>
	</div>
</li>

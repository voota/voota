<?php use_helper('VoFormat') ?>

<li>
	<div class="avatar">
    	<?php echo image_tag(S3Voota::getImagesUrl().'/'.$reviewable->getImagePath().'/cc_s_'.$reviewable->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $reviewable)) .'"') ?>
    </div>
	<h4 class="name"><?php echo link_to(cutToLength($reviewable->getLongName()), $reviewable->getModule().'/show?id='.$reviewable->getVanity())?></h4>
  <div class="votes">
		<?php include_partial('general/sparkline_box', array('id' => 'sparkline_t6_'.$reviewable->getId())) ?>
		<span class="votes-count">
			<?php if ($showVotes):?>
				<?php if ($reviewable->getSumut() > 0 && $reviewable->getSumdt() > 0): ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => $reviewable->getSumut()),$reviewable->getSumut())) ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => $reviewable->getSumdt()), $reviewable->getSumdt())) ?>
				<?php elseif ($reviewable->getSumut() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $reviewable->getSumut()), $reviewable->getSumut()) ?>				
				<?php elseif ($reviewable->getSumdt() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto negativo|(1,+Inf]%1% votos negativos', array('%1%' => $reviewable->getSumdt()), $reviewable->getSumdt()) ?>				
				<?php endif?>  
			<?php endif ?>
		</span>
	</div>
</li>

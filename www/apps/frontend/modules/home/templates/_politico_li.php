<?php use_helper('VoFormat') ?>

<li>
	<div class="avatar">
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
    </div>
	<h4 class="name"><?php echo link_to(cutToLength("".$politico->getNombre() ." ". $politico->getApellidos(), 35) . ($politico->getPartido()?" (" . $politico->getPartido() .")":''), 'politico/show?id='.$politico->getVanity())?></h4>
    <p class="votes">
  		<?php include_partial('sparkline_box', array('id' => $id)) ?>
		<span class="votes-count">
			<?php if ($showVotes):?>
				<?php if ($politico->getSumut() > 0 && $politico->getSumdt() > 0): ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => $politico->getSumut()),$politico->getSumut())) ?>
					<?php echo str_replace  (" ", "&nbsp;", format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => $politico->getSumdt()), $politico->getSumdt())) ?>
				<?php elseif ($politico->getSumut() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $politico->getSumut()), $politico->getSumut()) ?>				
				<?php elseif ($politico->getSumdt() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto negativo|(1,+Inf]%1% votos negativos', array('%1%' => $politico->getSumdt()), $politico->getSumdt()) ?>				
				<?php endif?>  
			<?php endif ?>
		</span>
	</p>
</li>

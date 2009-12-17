<li>
	<div class="avatar">
    	<?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png'), 'alt="Foto de '. $politico .'" , class="separacionFotoRanking"') ?>
    </div>
	<h4 class="name"><?php echo link_to($politico. ($politico->getPartido()==''?"":" (".$politico->getPartido().")"), 'politico/show?id='.$politico->getVanity())?></h4>
    <p class="votes">
    	<span id="<?php echo "sparkline_".$politico->getId()?>"></span>
		<span class="votes-count">
			<?php if ($showVotes):?>
				<?php if ($politico->getSumu() > 0 && $politico->getSumd() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 positivo|(1,+Inf]%1% positivos', array('%1%' => $politico->getSumu()),$politico->getSumu()) ?>
					<?php echo format_number_choice('[0]0|[1] y 1 negativo|(1,+Inf] y %1% negativos', array('%1%' => $politico->getSumd()), $politico->getSumd()) ?>
				<?php elseif ($politico->getSumu() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto positivo|(1,+Inf]%1% votos positivos', array('%1%' => $politico->getSumu()), $politico->getSumu()) ?>				
				<?php elseif ($politico->getSumd() > 0): ?>
					<?php echo format_number_choice('[0]0|[1]1 voto negativo|(1,+Inf]%1% votos negativos', array('%1%' => $politico->getSumd()), $politico->getSumd()) ?>				
				<?php endif?>  
			<?php endif ?>
		</span>
	</p>
</li>

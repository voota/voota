<?php if (count($politicos) > 0):?>
<tr>
	<td class="partido">
	  <?php if($geoName): ?>
		<a href="<?php echo url_for('lista/show?partido='.$partido->getAbreviatura().'&convocatoria='.$convocatoria->getNombre().'&vanity='.$convocatoria->getEleccion()->getVanity().'&geo='.$geoName) ?>"><?php echo __('Lista de %1%', array('%1%' => $partido->getAbreviatura())) ?></a>
	  <?php else:?>
		<a href="<?php echo url_for('partido/show?id='.$partido->getAbreviatura()) ?>"><?php echo $partido->getAbreviatura();?></a>
	  <?php endif ?>
	</td>
    <td class="escanos"><?php echo $numEscanyos ?></td>
    <td class="politicos">
    	<?php $idx=0;foreach($politicos as $politico):$idx++; ?>
    	  <?php if($idx < 21):?>
        	<img class="politico" id="<?php echo "politico_". $politico->getId()?>" src="<?php echo S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen() ?>" alt="<?php echo $politico ?>" />
            <script type="text/javascript" charset="utf-8">
                $("#<?php echo "politico_". $politico->getId()?>").data('positive_votes', <?php echo $politico->getSumu() ?>);
                $("#<?php echo "politico_". $politico->getId()?>").data('negative_votes', <?php echo $politico->getSumd() ?>);
            </script>
          <?php endif ?>
		<?php endforeach ?>
          <?php if(count($politicos) > 20): ?>
          		<?php echo __('(y %1% más)', array('%1%' => count($politicos) - 20))?>
          <?php endif ?>
	</td>
</tr>
<?php endif ?>
<?php if (count($politicos) > 0):?>
<tr>
	<td class="partido"><a href="<?php echo url_for('lista/show?partido='.$partido->getAbreviatura().'&convocatoria='.$convocatoria->getNombre().'&vanity='.$convocatoria->getEleccion()->getVanity().'&geo='.$geoName) ?>"><?php echo $partido->getAbreviatura();?></a></td>
    <td class="escanos">35</td>
    <td class="politicos">
    	<?php foreach($politicos as $politico): ?>
        	<img class="politico" id="<?php echo "politico_". $politico->getId()?>" src="<?php echo S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen() ?>" alt="<?php echo $politico ?>" />
            <script type="text/javascript" charset="utf-8">
                $("#<?php echo "politico_". $politico->getId()?>").data('positive_votes', <?php echo $politico->getSumu() ?>);
                $("#<?php echo "politico_". $politico->getId()?>").data('negative_votes', <?php echo $politico->getSumd() ?>);
            </script>
		<?php endforeach ?>
	</td>
</tr>
<?php endif ?>
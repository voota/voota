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
    	  <?php if($idx < ($numEscanyos+1) && $idx <= 20):?>
    	    <?php echo link_to(image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen(), 'id="politico_'.$politico->getId().'" class="politico" width="36" height="36" alt="'. $politico .'"'), 'politico/show?id='.$politico->getVanity()) ?>
          <script type="text/javascript">
            $("#<?php echo "politico_". $politico->getId()?>").data('nombre', '<?php echo $politico ?>')
            $("#<?php echo "politico_". $politico->getId()?>").data('url', '<?php echo url_for('politico/show?id='.$politico->getVanity()) ?>')
            $("#<?php echo "politico_". $politico->getId()?>").data('positive_votes', '<?php if ($convocatoria->getClosedAt()):?><?php $lc = $politico->getListaCalles(); echo $lc[0]->getSumu()?><?php else: ?><?php echo $politico->getSumu() ?><?php endif ?> <?php echo __('a favor') ?>');
            $("#<?php echo "politico_". $politico->getId()?>").data('negative_votes', '<?php if ($convocatoria->getClosedAt()):?><?php $lc = $politico->getListaCalles(); echo $lc[0]->getSumd()?><?php else: ?><?php echo $politico->getSumd() ?><?php endif ?> <?php echo __('en contra') ?>');
          </script>
          <?php endif ?>
  		<?php endforeach ?>
      <?php if($numEscanyos > 20): ?>
    		<?php echo __('(y %1% más)', array('%1%' => $numEscanyos - 20))?>
      <?php endif ?>
  	</td>
  </tr>
<?php endif ?>
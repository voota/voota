<?php use_helper('I18N') ?>

<h2>
  <img src="/images/lista-oficial.png" alt="<?php echo __('Lista oficial del partido')?>" />
  <?php echo __('Lista oficial del partido')?>
  <span class="versus">vs</span>
  <img src="/images/lista-calle.png" alt="<?php echo __('Lo que dice la calle')?>" />
  <?php echo __('Lo que dice la calle') ?>
</h2>

<p class="summary"><?php echo __('Lista electoral %1% %2% %3%', array(
	'%1%' => $lista->getPartido(),
	'%2%' => $lista->getConvocatoria()->getEleccion()->getNombre(),
	'%3%' => $lista->getConvocatoria()->getNombre()
)) ?></p>

<div class="selector-convocatoria">
    <ul>
      <?php if($geoName):?>
      	<li><a href="<?php echo url_for('lista/show?convocatoria='.
      		$lista->getConvocatoria()->getNombre().
      		'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity().
      		'&geo='.$geoName.
      		'&partido='.$lista->getPartido()->getAbreviatura()
      		) ?>"><?php echo $institucionName ?></a></li>
      <?php else:?>
      	<li><span><?php echo $institucionName ?></span></li>
      <?php endif ?>
      <?php foreach ($geos as $geo):?>
        <?php if($geoName && $geo->getNombre() == $geoName):?>
	      <li><span><?php echo $geo->getNombre()?></span></li>
        <?php else:?>
	      <li><a href="<?php echo url_for('eleccion/show?convocatoria='.$lista->getConvocatoria()->getNombre().'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity().'&geo='.$geo->getNombre())?>"><?php echo $geo->getNombre()?></a></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
</div>

<table>
  <thead>
    <tr>
      <th class="politico" colspan="3"><?php echo __('Lista oficial del partido (%nombre%)', array('%nombre%' => $lista->getPartido()->getAbreviatura())) ?></th>
      <th class="politico" colspan="3"><?php echo __('Lo que dice la calle') ?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
        <?php // TODO: Cambiar enlaces y añadir flechita; ver cualquier rankingSuccess.php ?>
        <a href="#" title="<?php echo __('Ordenar por votos positivos: Los más votados primero / los menos votados primero') ?>"><?php echo __('Votos +') ?></a>
        <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
        <?php // if (strpos($order, 'p') === 0): ?>
      		<?php // echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php // endif ?>
      </th>
      <th class="negative-votes">
        <?php // TODO: Cambiar enlaces y añadir flechita; ver cualquier rankingSuccess.php ?>
        <a href="#" title="<?php echo __('Ordenar por votos negativos: Los más votados primero / los menos votados primero') ?>"><?php echo __('Votos -') ?></a>
        <?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
        <?php // if (strpos($order, 'n') === 0): ?>
      		<?php // echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php // endif ?>
      </th>
    </tr>
  </thead>
  
  <tbody>
    <?php $idx = 0;foreach ($politicosListaVoota as $politico): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
        <td class="position">
        	<?php if (isset($politicosListaOficial[$idx])):?>
        		<?php echo $idx ?>.
        	<?php endif?>
        </td>
        <td class="photo">
        	<?php if (isset($politicosListaOficial[$idx])):?>
        		<?php echo image_tag(S3Voota::getImagesUrl().'/'.$politicosListaOficial[$idx]->getImagePath().'/bw_s_'.$politicosListaOficial[$idx]->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politicosListaOficial[$idx])) .'"') ?>
        	<?php endif?>
        </td>
        <td class="name">
        	<?php if (isset($politicosListaOficial[$idx])):?>
        		<a class="gris" href="<?php echo url_for('politico/show?id='.$politicosListaOficial[$idx]->getVanity())?>"><? echo $politicosListaOficial[$idx] ?></a></td>
        	<?php endif?>
        <td class="position"><?php echo $idx ?>.</td>
        <td class="photo"><?php echo image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?></td>
        <td class="name"><a href="<?php echo url_for('politico/show?id='.$politico->getVanity())?>"><? echo $politico ?></a></td>
        <td class="voto">
          <?php include_component_slot('quickvote', array('entity' => $politico)) ?>
        </td>
        <td class="positive-votes">89</td>
        <td class="negative-votes">33</td>
      </tr>
    <?php $idx++;endforeach ?>
  </tbody>
</table>
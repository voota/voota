<?php use_helper('I18N') ?>
<?php use_helper('VoFormat') ?>

<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'ele')) ?>
<?php end_slot('menu') ?>

<h2>
  <img src="/images/lista-oficial.png" alt="<?php echo __('Lista oficial del partido')?>" />
  <?php echo __('Lista oficial del partido')?>
  <span class="versus">vs</span>
  <img src="/images/lista-calle.png" alt="<?php echo __('Lo que dice la calle')?>" />
  <?php echo __('Lo que dice la calle') ?>
</h2>

<p class="summary"><?php echo __('Lista electoral') ?> 
  <a href="<?php echo url_for('partido/show?id='.$lista->getPartido()->getVanity())?>"><?php echo $lista->getPartido()?></a>, 
  <a href="<?php echo url_for('eleccion/show?convocatoria='.$lista->getConvocatoria()->getNombre().'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity())?>"><?php echo $lista->getConvocatoria()->getEleccion()->getNombre()?> <?php echo $lista->getConvocatoria()->getNombre() ?></a>
</p>

<div class="selector-convocatoria">
  <ul>
    <?php foreach ($geos as $geo):?>
      <?php if($geoName && $geo->getNombre() == $geoName):?>
        <li><span><?php echo $geo->getNombre()?></span></li>
      <?php else:?>
	      <li><a href="<?php echo url_for('lista/show?partido='.$lista->getPartido()->getAbreviatura().'&convocatoria='.$lista->getConvocatoria()->getNombre().'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity().'&geo='.$geo->getNombre())?>"><?php echo $geo->getNombre()?></a></li>
      <?php endif ?>
    <?php endforeach ?>
  </ul>
</div>

<table>
  <thead>
    <tr>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Lista oficial del partido (%nombre%)', array('%nombre%' => $lista->getPartido()->getAbreviatura())) ?></th>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Lo que dice la calle') ?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
        <a href="<?php echo url_for('lista/show?partido='.$lista->getPartido()->getAbreviatura().'&convocatoria='.$lista->getConvocatoria()->getNombre().'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity().'&geo='.$lista->getGeo()->getNombre().
        		($order=='pd'?"&o=pa":''))?>" 
        	rel="nofollow" 
        	title="<?php echo secureString(__('Ordenar por votos positivos: Los más votados primero / los menos votados primero')) ?>"><?php echo __('Votos +') ?></a>
        <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
        <?php if (strpos($order, 'p') === 0): ?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
      	<?php endif ?>
      </th>
      <th class="negative-votes">
        <a href="<?php echo url_for('lista/show?partido='.$lista->getPartido()->getAbreviatura().'&convocatoria='.$lista->getConvocatoria()->getNombre().'&vanity='.$lista->getConvocatoria()->getEleccion()->getVanity().'&geo='.$lista->getGeo()->getNombre().
        		($order=='nd'?"&o=na":'&o=nd'))?>" 
        	rel="nofollow" 
        	title="<?php echo secureString(__('Ordenar por votos negativos: Los más votados primero / los menos votados primero')) ?>"><?php echo __('Votos -') ?></a>
        <?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
        <?php if (strpos($order, 'n') === 0): ?>
      		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
      	<?php endif ?>
      </th>
    </tr>
  </thead>
  
  <tbody>
    <?php $idx = 0;foreach ($politicosListaVoota as $politico): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
        <td class="position">
        	<?php //if (isset($politicosListaOficial[$idx]) || count($politicosListaOficial) == 0):?>
        		<?php echo $idx+1 ?>.
        	<?php //endif?>
        </td>
        <td class="photo">
        	<?php if (isset($politicosListaOficial[$idx])):?>
        		<?php echo image_tag(S3Voota::getImagesUrl().'/'.$politicosListaOficial[$idx]->getImagePath().'/bw_s_'.$politicosListaOficial[$idx]->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politicosListaOficial[$idx])) .'"') ?>
        	<?php else:?>
        		<?php echo image_tag(S3Voota::getImagesUrl().'/politicos/cc_s_p_unknown.png', 'alt="'. __('No disponible').'"') ?>
        	<?php endif?>
        </td>
        <td class="name name-lista-oficial">
        	<?php if (isset($politicosListaOficial[$idx])):?>
        		<a class="gris" href="<?php echo url_for('politico/show?id='.$politicosListaOficial[$idx]->getVanity())?>"><?php echo $politicosListaOficial[$idx] ?></a></td>
			    <?php else:?>
        		<?php echo __('No disponible') ?>
        	<?php endif?>
        <td class="position"><?php echo $idx+1 ?>.</td>
        <td class="photo"><?php echo image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?></td>
        <td class="name"><a href="<?php echo url_for('politico/show?id='.$politico->getVanity())?>"><?php echo $politico ?></a></td>
        <td class="voto">
          <?php include_component_slot('quickvote', array('entity' => $politico)) ?>
        </td>
        <td class="positive-votes"><?php echo $politico->getSumu() ?></td>
        <td class="negative-votes"><?php echo $politico->getSumd() ?></td>
      </tr>
    <?php $idx++;endforeach ?>
  </tbody>
</table>
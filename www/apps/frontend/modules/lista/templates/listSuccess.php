<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
 
<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'ele')) ?>
<?php end_slot('menu') ?>


<h2><?php echo $title ?></h2>

<?php if (!$hide):?>
<div class="filter">
 <?php if($autonomicas || $municipales): ?><a href="<?php echo url_for("lista/list".($partido?"?partido=$partido":'')) ?>"><?php endif ?>
  <?php echo __('Todas las listas')?>
 <?php if($autonomicas || $municipales): ?></a><?php endif ?>
 · 
 <?php if(!$autonomicas): ?><a href="<?php echo url_for("lista/list?a=1".($partido?"&partido=$partido":'')) ?>"><?php endif ?>
  <?php echo __('Sólo las autonómicas')?>
 <?php if(!$autonomicas): ?></a><?php endif ?>
 ·
 <?php if(!$municipales): ?><a href="<?php echo url_for("lista/list?m=1".($partido?"&partido=$partido":'')) ?>"><?php endif ?>
  <?php echo __('Sólo las municipales')?>
 <?php if(!$municipales): ?></a><?php endif ?>
</div>
<?php endif ?>



<table class="rankings" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="position"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="lists"></th>
      <th class="date"><?php echo __('Fecha de elección')?></th>
    </tr>
  </thead>


  <tbody>
   <?php foreach($results = $pager->getResults() as $idx => $lista): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="photo">
          <?php echo !$lista->getPartido()->getImagen()?'':image_tag(S3Voota::getImagesUrl().'/partidos/cc_s_'. $lista->getPartido()->getImagen(), ' width="36" height="36" alt="'. __('Imagen de %1%', array('%1%' =>  $lista->getPartido())) .'"') ?>
          <?php echo !$lista->getConvocatoria()->getImagen()?'':image_tag(S3Voota::getImagesUrl().'/elecciones/cc_s_'. $lista->getConvocatoria()->getImagen(), ' width="36" height="36" alt="'. __('Imagen de %1%', array('%1%' =>  $lista->getConvocatoria()->getEleccion()->getNombre())) .'"') ?>
  	    </td>
        <td class="name">
          <?php $multi = false; $count=0; foreach ($lista->getConvocatoria()->getListas() as $aLista){ if($aLista->getPartidoId() == $lista->getPartidoId()){if ($count++ > 1) $multi = true;}}?>
          <?php echo link_to(	cutToLength($lista->getPartido()->getAbreviatura().", ". $lista->getConvocatoria(). ($multi?(", ". $lista->getCircunscripcion()):'') , 105), 'lista/show?vanity='. $lista->getConvocatoria()->getEleccion()->getVanity() .'&convocatoria='.$lista->getConvocatoria()->getNombre().'&geo='.$lista->getCircunscripcion()->getGeo()->getNombre().'&partido='.$lista->getPartido()->getAbreviatura()
          ) ?>
        </td>
        <td class="lists">
         &nbsp;
        </td>
        <td class="date">
         <?php echo format_date($lista->getConvocatoria()->getFecha(), 'd/M/y') ?><?php if($lista->getConvocatoria()->getClosedAt()):?> <?php echo __('(finalizada)')?><?php endif ?>
        </td>
      </tr>

   <?php endforeach ?>
  </tbody>
<?php /* ?>
<?php */ ?>
</table>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $pager, 'url' => "$route".($autonomicas?'?a=1':'').($municipales?'?m=1':'').($partido?"&partido=$partido":''), 'page_var' => "page")) ?>
</p>

<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'ele')) ?>
<?php end_slot('menu') ?>


<h2><?php echo $title ?></h2>
<div class="filter">
 <?php if($autonomicas || $municipales): ?><a href="<?php echo url_for("eleccion/list") ?>"><?php endif ?>
  <?php echo __('Todas las elecciones')?>
 <?php if($autonomicas || $municipales): ?></a><?php endif ?>
 · 
 <?php if(!$autonomicas): ?><a href="<?php echo url_for("eleccion/list?a=1") ?>"><?php endif ?>
  <?php echo __('Sólo las autonómicas')?>
 <?php if(!$autonomicas): ?></a><?php endif ?>
 ·
 <?php if(!$municipales): ?><a href="<?php echo url_for("eleccion/list?m=1") ?>"><?php endif ?>
  <?php echo __('Sólo las municipales')?>
 <?php if(!$municipales): ?></a><?php endif ?>
</div>



<table class="rankings" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="position"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="lists"><?php echo __('Nº de listas')?></th>
      <th class="date"><?php echo __('Fecha de elección')?></th>
    </tr>
  </thead>


  <tbody>
   <?php foreach($results = $pager->getResults() as $idx => $convocatoria): ?>
    <?php foreach ($convocatoria->getEleccion()->getEleccionInstitucions() as $eleccionInstuticion):?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="photo">
          <?php echo !$convocatoria->getImagen()?'':image_tag(S3Voota::getImagesUrl().'/elecciones/cc_s_'. $convocatoria->getImagen(), ' width="36" height="36" alt="'. __('Imagen de %1%', array('%1%' =>  $convocatoria->getEleccion()->getNombre())) .'"') ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	cutToLength($eleccionInstuticion->getInstitucion()->getGeo()->getNombre(). " (" .$convocatoria->getEleccion()->getNombre()." ".$convocatoria->getNombre() .")" , 105), 'eleccion/show?vanity='. $convocatoria->getEleccion()->getVanity() .'&convocatoria='.$convocatoria->getNombre()//. ($partido == 'all'?'':"&partido=$partido"). ($institucion == '0'?'':"&institucion=$institucion")
          ) ?>
        </td>
        <td class="lists">
         <?php echo count($convocatoria->getListas()) ?>
        </td>
        <td class="date">
         <?php echo format_date($convocatoria->getFecha(), 'd/M/y') ?><?php if($convocatoria->getClosedAt()):?> <?php echo __('(finalizada)')?><?php endif ?>
        </td>
      </tr>
    <?php endforeach ?>
   <?php endforeach ?>
  </tbody>
<?php /* ?>
<?php */ ?>
</table>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $pager, 'url' => "$route".($autonomicas?'?a=1':'').($municipales?'?m=1':''), 'page_var' => "page")) ?>
</p>

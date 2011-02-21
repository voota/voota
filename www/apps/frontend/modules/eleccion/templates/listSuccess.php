<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<?php slot('menu') ?>
	<?php include_partial('global/menu', array('tab' => 'ele')) ?>
<?php end_slot('menu') ?>


<h2><?php echo $title ?></h2>
<div class="filter">
 <?php echo __('Todas las elecciones')?> 
 · 
 <a href="#"><?php echo __('Sólo las autonómicas')?></a>
 ·
 <a href="#"><?php echo __('Sólo las municipales')?></a>
</div>



<table class="rankings" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="position"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="name"><?php echo __('Nº de listas')?></th>
      <th class="name"><?php echo __('Fecha de elección')?></th>
    </tr>
  </thead>


  <tbody>
    <?php foreach($results = $pager->getResults() as $idx => $convocatoria): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="photo">
          <?php // echo link_to(image_tag(S3Voota::getImagesUrl().'/'.$convocatoria->getImagePath().'/cc_s_'.$convocatoria->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $convocatoria)) .'"'), 'politico/show?id='.$convocatoria->getVanity()) ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	cutToLength("".$convocatoria->getEleccion()->getNombre()." ".$convocatoria->getNombre() , 105), 'eleccion/show?vanity='. $convocatoria->getEleccion()->getVanity() .'&convocatoria='.$convocatoria->getNombre()//. ($partido == 'all'?'':"&partido=$partido"). ($institucion == '0'?'':"&institucion=$institucion")
          ) ?>
        </td>
        <td class="name">
         <?php echo count($convocatoria->getListas()) ?>
        </td>
        <td class="name">
         <?php echo format_date($convocatoria->getFecha(), 'd/M/y') ?><?php if($convocatoria->getClosedAt()):?> <?php echo __('(finalizada)')?><?php endif ?>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>
<?php /* ?>
<?php */ ?>
</table>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $pager, 'url' => "$route", 'page_var' => "page")) ?>
</p>

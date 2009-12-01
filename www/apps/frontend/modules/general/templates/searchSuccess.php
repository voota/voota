<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>

<!-- CONTENT LEFT-->
<div id="contentRankingLeft">
<div title="ficha">
<span class="nombrePolitico">Resultados</span>
<?php if ( $res && $res['total_found'] > 0):?>
	<h5><?php echo $res['total_found']  == 1?__('%1% resultado encontrado buscando "%2%"', array('%1%' => format_number($res['total_found'], 'es_ES'), '%2%' => $q)):__('%1% resultados encontrados buscando "%2%"', array('%1%' => format_number($res['total_found'], 'es_ES'), '%2%' => $q))?> 
	</h5>
<?php endif ?>
<div class="limpiar"></div>

</div>
<div class="limpiar"></div>
<div class="listadoRanking">
<?php if ( $res && $res['total_found'] > 0):?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="cabeceraRanking">
    <td class="nombreRanking"><h6><?php echo __('Nombre')?></h6></td>


    <td>&nbsp;</td>
  </tr>

<?php foreach($politicosPager->getResults() as $idx => $politico): ?>
  <tr class="listaRanking">
    <td class="nombreRanking" colspan="2"><h6>   
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png')
    	, 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'" , class=separacionFotoRanking') ?>
    
 <?php echo link_to(
 	"".$politico->getNombre() ." ". $politico->getApellidos()
 	, 'politico/show?id='.$politico->getVanity()
 ) ?><?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido() ?>)<?php endif ?><?php if (count($politico->getPoliticoInstitucions()) > 0): ?>, 
	<?php foreach ($politico->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php echo $politicoInstitucion->getInstitucion()->getNombre() ?><?php endforeach ?>
  <?php endif ?>

     </h6></td>
  </tr>
<?php endforeach ?>


</table>
<?php else: ?>
	<h5><?php echo __('No se han encontrado resultados para "%1%".', array('%1%' => $q)) ?></h5>
<?php endif ?>

</div>
<!--politico -->
<div class="limpiar"></div>
<!--fin politico -->

<!--total votos -->
<div class="limpiar"></div>
<!--fin total votos -->
<!--paginacion -->
<div class="limpiar"></div>
<div class=" listadoRankingPoliticos">
<div id="paginacion" style="">

<?php if ( $res && $res['total_found'] > 0):?>
<?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => "@search?q=$q&", 'page_var' => "page")) ?>
<?php endif ?>

</div>
</div>
<!--fin paginacion -->
<div class="limpiar"></div>
<?php /* ?>
<div class="der">
  <input name="buscar2" type="text" class="input">
  <input name="buscar" type="button" class="button" value="Buscar">
</div>
<?php */ ?>
</div>
<!-- FIN CONTENT LEFT -->
<!-- CONTENT RIGHT -->

<!--  FIN CONTENT RIGHT -->
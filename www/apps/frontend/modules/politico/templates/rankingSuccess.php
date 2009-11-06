<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<script>  
$(document).ready(function(){
	rankingReady();
});
</script>

<div id="mainInterior">
<!-- CONTENT -->
<div id="content">
<!-- CONTENT LEFT-->
<div id="contentRankingLeft">
<div title="ficha">
<span class="nombrePolitico"><?php echo __('Ranking de políticos')?>
<?php echo $institucion=='0'?'':"en el $institucion" ?>

<?php echo ($institucion!='0' && $partido!='all')?'-':'' ?>

<?php echo $partido=='all'?'':$partido ?>
<label>

<?php echo select_tag('partido', options_for_select($partidos_arr, $partido), array('class'  => 'input', 'id' => 'partido_selector')) ?>



</label>
</span>
<div class="limpiar"></div>
<div><h6>
  <?php 
    if ($partido == 'all'){
	  	$url = "@ranking_".$sf_user->getCulture('es')."_all";
	  	echo link_to(
	 	'Todas las instituciones'
	 	, "$url"
	 	, array('class' => $institucion=='0'?'flechita':''));
    }
    else {
	  	$url = "@ranking_".$sf_user->getCulture('es')."_partido";
	  	echo link_to(
	 	'Todas las instituciones'
	 	, "$url?partido=$partido"
	 	, array('class' => $institucion=='0'?'flechita':''));
    }
  ?>
<?php foreach($instituciones as $aInstitucion): ?>
 · 
  <?php 
  	$url = ($sf_user->getCulture('es') == 'es')?'@ranking_es':'@ranking_ca';
  	echo link_to(
 	$aInstitucion->getNombreCorto()
 	, "$url?partido=$partido&institucion=".$aInstitucion->getNombreCorto()
 	, array('class' => $aInstitucion->getNombre()==$institucion?'flechita':'')
 ) ?>
 
<?php endforeach ?>

</h6>
</div>
</div>
<div class="limpiar"></div>
<div class="listadoRanking">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="cabeceraRanking">
    <td class="nombreRanking"><h6><?php echo __('Nombre')?></h6></td>
    <td class="votosUp"><h6>
    	<?php echo link_to(__('Votos'), "$route&o=".($order=='pd'?'pa':'pd'));?>
    	<?php echo image_tag('icoMiniUp.png', 'pa') ?>
    	<?php if (strpos($order, 'p') === 0):?>
    		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'down':'up') ?>
    	<?php endif?>    	
    </h6></td>
    <td class="votosDown"><h6>
    	<?php echo link_to(__('Votos'), "$route&o=".($order=='nd'?'na':'nd'));?>
    	<?php echo image_tag('icoMiniDown.png', 'down') ?>
    	<?php if (strpos($order, 'n') === 0):?>
    		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'down':'up') ?>
    	<?php endif?>
    </h6></td>
    <td>&nbsp;</td>
  </tr>
  
<?php foreach($politicosPager->getResults() as $politico): ?>
  <tr class="listaRanking">
    <td class="nombreRanking"><h6>
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png')
    	, 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>
    
 <?php echo link_to(
 	"".$politico->getNombre() ." ". $politico->getApellidos() . ($politico->getPartido()?" (" . $politico->getPartido() .")":'')
 	, 'politico/show?id='.$politico->getId()
 ) ?>
 
     
     </h6></td>


    <td class="votosDown"><h6><?php echo $politico->getSumu()?></h6></td>
    <td class="votosDown"><h6><?php echo $politico->getSumd()?></h6></td>
    <td>&nbsp;</td>
  </tr>
<?php endforeach ?>


  <tr>
    <td>&nbsp;</td>
    <td class="votosDown"><h6>
    <?php echo __('Total')?>
    	<?php echo image_tag('icoMiniUp.png', 'up') ?>
    	<?php echo $totalUp?>
    </h6></td>
    <td class="votosDown"><h6>
    	<?php echo __('Total')?>
    	<?php echo image_tag('icoMiniDown.png', 'down') ?>
    	<?php echo $totalDown?>
    </h6></td>
    <td>&nbsp;</td>
  </tr>
</table>

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

<?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => 'politico/ranking?', 'page_var' => "page", 'order' => $order)) ?>

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


<div class="limpiar"></div>

</div>
<!-- FIN CONTENT -->
</div>


<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<script>  
$(document).ready(function(){
	rankingReady();
	  <?php foreach($politicosPager->getResults() as $politico): ?>
	  <?php include_component_slot('sparkline', array('politico' => $politico)) ?>
	  <?php endforeach ?>
});
</script>

<!-- CONTENT LEFT-->
<div id="contentRankingLeft">
<div title="ficha">
<span class="nombrePolitico"><?php echo $title ?>

<label>

<?php echo select_tag('partido', options_for_select($partidos_arr, $partido), array('class'  => 'input', 'id' => 'partido_selector')) ?>



</label>
</span>
<div class="limpiar"></div>
<div id="inst_long" class="hidden"><h6>
  <?php 
    if ($partido == 'all'){
	  	$url = "@ranking_".$sf_user->getCulture('es')."_all";
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "$url"
	 	, array('class' => $institucion=='0'?'flechita':''));
    }
    else {
	  	$url = "@ranking_".$sf_user->getCulture('es')."_partido";
	  	echo link_to(
	 	__('Todas las instituciones')
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
 	, "$url?partido=$partido&institucion=".$aInstitucion->getVanity()
 	, array('class' => $aInstitucion->getVanity()==$institucion?'flechita':'')
 ) ?>
 <?php endforeach ?>
  · 
 [<a href="#" onclick="return inst_to_short();"><?php echo __('ver menos ...')?></a>]
</h6></div>
<div id="inst_short"><h6>
  <?php 
    if ($partido == 'all'){
	  	$url = "@ranking_".$sf_user->getCulture('es')."_all";
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "$url"
	 	, array('class' => $institucion=='0'?'flechita':''));
    }
    else {
	  	$url = "@ranking_".$sf_user->getCulture('es')."_partido";
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "$url?partido=$partido"
	 	, array('class' => $institucion=='0'?'flechita':''));
    }
  ?>
 <?php $idx = 0; ?>  
 <?php foreach($instituciones as $aInstitucion): ?>
  <?php 
  $idx++;
  if ($idx <= SfVoUtil::SHORT_INSTITUCIONES_NUM || $aInstitucion->getVanity()==$institucion) {
  ?>  
 · 
  <?php 
  	$url = ($sf_user->getCulture('es') == 'es')?'@ranking_es':'@ranking_ca';
  	echo link_to(
 	$aInstitucion->getNombreCorto()
 	, "$url?partido=$partido&institucion=".$aInstitucion->getVanity()
 	, array('class' => $aInstitucion->getVanity()==$institucion?'flechita':'')
 ) ?>
  <?php 
  }
  ?>  
 <?php endforeach ?>
<?php if(count($instituciones) > SfVoUtil::SHORT_INSTITUCIONES_NUM): ?>
  · 
 [<a href="#" onclick="return inst_to_long();"><?php echo __('ver más ...')?></a>]
<?php endif ?>
</h6></div>

</div>
<div class="limpiar"></div>
<div class="listadoRanking">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="cabeceraRanking">
    <td>&nbsp;</td>
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

<?php foreach($politicosPager->getResults() as $idx => $politico): ?>
  <tr class="listaRanking">
	<td class="votosDown"><span id="<?php echo "sparkline_".$politico->getId()?>"></span></td>
    <td class="nombreRanking"><h6><?php echo format_number($politicosPager->getFirstIndice() + $idx, 'es_ES') ?>. <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png')
    	, 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'" , class=separacionFotoRanking') ?>
    
 <?php echo link_to(
 	cutToLength("".$politico->getNombre() ." ". $politico->getApellidos(), 35) . ($politico->getPartido()?" (" . $politico->getPartido() .")":'')
 	, 'politico/show?id='.$politico->getVanity()//. ($partido == 'all'?'':"&partido=$partido"). ($institucion == '0'?'':"&institucion=$institucion")
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

<?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => "$route&", 'page_var' => "page", 'order' => $order)) ?>

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

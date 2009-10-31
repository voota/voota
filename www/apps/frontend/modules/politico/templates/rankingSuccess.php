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
<span class="nombrePolitico">Ranking de políticos
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
  	$url = $sf_user->getCulture('es')?'@ranking_es':'@ranking_ca';
  	echo link_to(
 	$aInstitucion->getNombreCorto()
 	, "$url?partido=$partido&institucion=".$aInstitucion->getNombreCorto()
 	, array('class' => $aInstitucion->getNombre()==$institucion?'flechita':'')
 ) ?>
 
 <!-- a href="#" onclick="changeInstitucion('<?php echo $aInstitucion->getNombre() ?>');" <?php echo $aInstitucion->getNombre()==$institucion?'class="flechita"':'' ?>><?php echo $aInstitucion->getNombre() ?></a -->
<?php endforeach ?>

</h6>
</div>
</div>
<div class="limpiar"></div>
<div class="listadoRanking">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="cabeceraRanking">
    <td class="nombreRanking"><h6><a href="#">Nombre</a> <img src="/images/flechaDown.gif" alt="Flecha Down"></h6></td>
    <td class="votosDown"><h6><a href="#">Votos </a> <img src="/images/icoMiniUp.png" alt="icono mano  up"> <img src="/images/flechaDown.gif" alt="Flecha Down"></h6></td>
    <td class="votosDown"><h6><a href="#">Votos </a> <img src="/images/icoMiniDown.png" alt="Icono mano down"> <img src="/images/flechaDown.gif" alt="Flecha Down"></h6></td>
    <td>&nbsp;</td>
  </tr>
  
<?php foreach($politicosPager->getResults() as $politico): ?>
  <tr class="listaRanking">
    <td class="nombreRanking"><h6>
    <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png'), 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>
    
 <?php echo link_to(
 	"".$politico->getNombre() ." ". $politico->getApellidos() . "(" . $politico->getPartido() .")"
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
    <td class="votosDown"><h6>Total <img src="/images/icoMiniUp.png" alt="icono mano  up"> 4515</h6></td>
    <td class="votosDown"><h6>Total <img src="/images/icoMiniUp.png" alt="icono mano  up"> 4515</h6></td>
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

<?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => 'politico/ranking?', 'page_var' => "page")) ?>

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


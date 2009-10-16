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

<?php echo ($institucion!='0' && $partido!='0')?'-':'' ?>

<?php echo $partido=='0'?'':$partido ?>
<label>

<?php echo select_tag('partido', options_for_select($partidos_arr, $partido), array('class'  => 'input', 'id' => 'partido_selector')) ?>



</label>
</span>
<div class="limpiar"></div>
<div><h6>
<a href="#" onclick="changeInstitucion('0');" <?php echo $institucion=="0"?'class="flechita"':'' ?>>Todas las instituciones</a>
<?php foreach($instituciones as $aInstitucion): ?>
 · <a href="#" onclick="changeInstitucion('<?php echo $aInstitucion->getNombre() ?>');" <?php echo $aInstitucion->getNombre()==$institucion?'class="flechita"':'' ?>><?php echo $aInstitucion->getNombre() ?></a>
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
    <?php echo image_tag('politicos/cc_s_'. (file_exists(sfConfig::get('sf_upload_dir').'/politicos/'.($politico->getImagen()))?$politico->getImagen():'p_unknown.png'), 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>
    
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


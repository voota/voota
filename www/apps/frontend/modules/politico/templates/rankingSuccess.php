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
     <a href="/es/politico/<?php echo $politico->getId(); ?>"><?php echo $politico->getNombre(); ?> <?php echo $politico->getApellidos(); ?> (<?php echo $politico->getPartido(); ?>)</a></h6></td>
    <td class="votosDown"><h6>455</h6></td>
    <td class="votosDown"><h6>455</h6></td>
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


<?php if ($politicosPager->haveToPaginate()): ?>
  <?php # echo link_to('&laquo;', 'politico/ranking?page='.$politicosPager->getFirstPage()) ?>
 <?php echo link_to('&lt;&lt;Anterior', 'politico/ranking?page='.$politicosPager->getPreviousPage(), array('class'  => 'numerosPag')) ?>
  
  <?php if ($politicosPager->getPage() > 3): ?>
    <?php echo link_to($politicosPager->getFirstPage(), 'politico/ranking?page='.$politicosPager->getFirstPage(), array('class'  => 'numerosPag')) ?>
    ...
  <?php endif ?>
  <?php $links = $politicosPager->getLinks(); foreach ($links as $page): ?>
    <?php echo ($page == $politicosPager->getPage()) ? $page : link_to($page, 'politico/ranking?page='.$page, array('class'  => 'numerosPag')) ?>
    <?php if ($page != $politicosPager->getCurrentMaxLink()): ?> <?php endif ?>
  <?php endforeach ?>
    <?php if ($politicosPager->getLastPage() != $politicosPager->getCurrentMaxLink()): ?>
    ...
    <?php echo link_to($politicosPager->getLastPage(), 'politico/ranking?page='.$politicosPager->getLastPage(), array('class'  => 'numerosPag')) ?>
    <?php endif ?>
    
  <?php echo link_to('Siguiente&gt;&gt;', 'politico/ranking?page='.$politicosPager->getNextPage(), array('class'  => 'numerosPag')) ?>
  <?php # echo link_to('&raquo;', 'politico/ranking?page='.$politicosPager->getLastPage()) ?>
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


<div class="limpiar"></div>

</div>
<!-- FIN CONTENT -->
</div>


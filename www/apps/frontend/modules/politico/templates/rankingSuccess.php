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

<h2>
  <?php echo $title ?>
  <?php echo select_tag('partido', options_for_select($partidos_arr, $partido), array('class'  => 'input', 'id' => 'partido_selector')) ?>
</h2>

<p id="institutions-long" class="hidden">
  <?php
    if ($partido == 'all'){
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "politico/ranking"
	 	, array('class' => $institucion=='0'?'active':''));
    }
    else {
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "politico/ranking?partido=$partido"
	 	, array('class' => $institucion=='0'?'active':''));
    }
  ?>

  <?php foreach($instituciones as $aInstitucion): ?>
    · 
    <?php echo link_to( $aInstitucion->getNombreCorto(),
 	                      "politico/ranking?partido=$partido&institucion=".$aInstitucion->getVanity(),
                        array('class' => $aInstitucion->getVanity()==$institucion?'active':'') )
    ?>
  <?php endforeach ?>
  · 
  [<a href="#" onclick="return institutions_to_short();"><?php echo __('ver menos ...')?></a>]
</p>

<p id="institutions-short">
  <?php 
    if ($partido == 'all'){
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "politico/ranking"
	 	, array('class' => $institucion=='0'?'active':''));
    }
    else {
	  	echo link_to(
	 	__('Todas las instituciones')
	 	, "politico/ranking?partido=$partido"
	 	, array('class' => $institucion=='0'?'active':''));
    }
  ?>
  <?php $idx = 0; ?>  
  <?php foreach($instituciones as $aInstitucion): ?>
    <?php $idx++; ?>
    <?php if ($idx <= SfVoUtil::SHORT_INSTITUCIONES_NUM || $aInstitucion->getVanity()==$institucion): ?>  
      · 
      <?php echo link_to(	$aInstitucion->getNombreCorto(),
 	                        "politico/ranking?partido=$partido&institucion=".$aInstitucion->getVanity(),
 	                        array('class' => $aInstitucion->getVanity()==$institucion?'active':'') )
 	    ?>
    <?php endif ?>  
  <?php endforeach ?>
  <?php if(count($instituciones) > SfVoUtil::SHORT_INSTITUCIONES_NUM): ?>
    · 
    [<a href="#" onclick="return institutions_to_long();"><?php echo __('ver más ...')?></a>]
  <?php endif ?>
</p>

<table border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="ranking"><?php echo __('Ranking')?></th>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="positive-votes">
      	<?php echo link_to(__('Votos +'), "$route&o=".($order=='pd'?'pa':'pd'));?>
      	<?php echo image_tag('icoUp20px.gif', 'pa') ?>
      	<?php if (strpos($order, 'p') === 0):?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'down':'up') ?>
      	<?php endif?>    	
      </th>
      <th class="negative-votes">
      	<?php echo link_to(__('Votos -'), "$route&o=".($order=='nd'?'na':'nd'));?>
      	<?php echo image_tag('icoDown20px.gif', 'down') ?>
      	<?php if (strpos($order, 'n') === 0):?>
      		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'down':'up') ?>
      	<?php endif?>
      </th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($politicosPager->getResults() as $idx => $politico): ?>
      <tr>
  	    <td class="ranking"><span id="<?php echo "sparkline_".$politico->getId()?>"></span></td>
  	    <td class="position"><?php echo format_number($politicosPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png'), 'alt="Foto '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	cutToLength("".$politico->getNombre() ." ". $politico->getApellidos(), 35) . ($politico->getPartido()?" (" . $politico->getPartido() .")":''), 'politico/show?id='.$politico->getVanity()//. ($partido == 'all'?'':"&partido=$partido"). ($institucion == '0'?'':"&institucion=$institucion")
          ) ?>
        </td>
        <td class="positive-votes"><?php echo $politico->getSumu()?></td>
        <td class="negative-votes"><?php echo $politico->getSumd()?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
  
  <tfoot>
    <tr>
      <td class="ranking"></td>
      <td class="position"></td>
      <td class="photo"></td>
      <td class="name"></td>
      <td class="positive-votes">
        <?php echo __('Total') ?>
    	  <?php echo image_tag('icoMiniUp.png', 'up') ?>
    	  <?php echo $totalUp?>
      </td>
      <td class="negative-votes">
      	<?php echo __('Total')?>
      	<?php echo image_tag('icoMiniDown.png', 'down') ?>
      	<?php echo $totalDown?>
      </td>
    </tr>
  </tfoot>
</table>

<p class="pagination">
  <?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => "$route&", 'page_var' => "page", 'order' => $order)) ?>
</p>
<?php use_helper('Form') ?>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<script type="text/javascript">  
$(document).ready(function(){
	rankingReady();
	  <?php foreach($politicosPager->getResults() as $politico): ?>
	  <?php include_component_slot('sparkline', array('politico' => $politico)) ?>
	  <?php endforeach ?>
});
</script>

<h2>
  <?php echo $pageTitle ?>
  <?php echo select_tag('partido', options_for_select($partidos_arr, $partido), array('class'  => 'input', 'id' => 'partido_selector')) ?>
</h2>

<?php include_partial('global/institucionList', array('instituciones' => $instituciones, 'partido' => $partido, 'institucion' => $institucion, 'showPartido' => true)) ?>


<table border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="ranking"></th>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="positive-votes">
      	<?php echo link_to(__('Votos +'), "$route&o=".($order=='pd'?'pa':'pd'));?>
      	<?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
      	<?php if (strpos($order, 'p') === 0):?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php endif?>    	
      </th>
      <th class="negative-votes">
      	<?php echo link_to(__('Votos -'), "$route&o=".($order=='nd'?'na':'nd'));?>
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php if (strpos($order, 'n') === 0):?>
      		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php endif?>
      </th>
    </tr>
  </thead>

  <tfoot>
    <tr>
      <td class="ranking"></td>
      <td class="position"></td>
      <td class="photo"></td>
      <td class="name"></td>
      <td class="positive-votes">
        <?php echo __('Total') ?>
    	  <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
    	  <?php echo $totalUp?>
      </td>
      <td class="negative-votes">
      	<?php echo __('Total')?>
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php echo $totalDown?>
      </td>
    </tr>
  </tfoot>

  <tbody>
    <?php foreach($politicosPager->getResults() as $idx => $politico): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="ranking"><?php include_partial('sparkline_box', array('politico' => $politico)) ?></td>
  	    <td class="position"><?php echo format_number($politicosPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
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
</table>

<p class="pagination">
  <?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => "$route&", 'page_var' => "page", 'order' => $order)) ?>
</p>
<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<script type="text/javascript">  
$(document).ready(function(){
	rankingReady();
	  <?php foreach($partidosPager->getResults() as $partido): ?>
	  <?php include_component_slot('sparkline', array('partido' => $partido)) ?>
	  <?php endforeach ?>
});
</script>

<h2>
  <?php echo $pageTitle ?>
</h2>

<?php include_partial('global/institucionList', array('instituciones' => $instituciones, 'partido' => $partido, 'institucion' => $institucion, 'linkType' => 'partido')) ?>


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
    <?php foreach($partidosPager->getResults() as $idx => $partido): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="ranking"><?php include_partial('sparkline_box', array('partido' => $partido)) ?></td>
  	    <td class="position"><?php echo format_number($partidosPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/cc_s_'.($partido->getImagen()!=''?$partido->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $partido)) .'"') ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	$partido->getNombre() . ' (' . $partido->getAbreviatura() . ')', 'partido/show?id='.$partido->getAbreviatura() ); ?>
        </td>
        <td class="positive-votes"><?php echo $partido->getSumu()?></td>
        <td class="negative-votes"><?php echo $partido->getSumd()?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $partidosPager, 'url' => "$route&", 'page_var' => "page", 'order' => $order)) ?>
</p>
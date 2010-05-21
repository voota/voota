<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<script type="text/javascript">  
  $(document).ready(function(){
	$("input#ac_institucion").autocomplete({
		source: '<?php echo url_for('politico/acInstitucion')?>',
		select: function(event, ui) { $("input#institucion").val(ui.item.id); }
	});
	
	$("#ac_filter_frm").submit(function(){
  	var ac_institucion = $('input#ac_institucion').val();
  	if (ac_institucion == '' || ac_institucion == $('input#ac_institucion').attr('title'))
  		$('input#institucion').val('all');

		return true;
	});	
  });
  $(window).load(function(){
    <?php foreach(($results = $partidosPager->getResults()) as $partido): ?>
      <?php include_component_slot('sparkline', array('reviewable' => $partido, 'id' => 'sparkline_'. $partido->getId())) ?>
    <?php endforeach ?>
  });
</script>

<h2><?php echo $pageTitle ?></h2>

<form id="ac_filter_frm" action="<?php echo url_for('partido/ranking')?>">
<input type="hidden" name="i" id="institucion" value="<?php echo $institucion ?>" />
<p>
	<?php echo __('Institución')?> <input type="text" id="ac_institucion" value="<?php echo $institucionAC ?>" title="<?php echo __('Parlamento europeo, Gobierno, Congreso...')?>" />
	<input type="submit" value="<?php echo __('Filtrar') ?>" />
</p>
</form>

<?php //include_partial('global/institucionList', array('instituciones' => $instituciones, 'partido' => $partido, 'institucion' => $institucion, 'linkType' => 'partido')) ?>
<?php include_partial('sfReviewFront/dialog') ?>


<table class="rankings" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="ranking"></th>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
      	<?php echo link_to(__('Votos +'), "$route".($order=='pd'?(!preg_match("/\?/",$route)?'?':'&')."o=pa":''), array('rel'  => 'nofollow', 'title' => __('Ordenar por votos positivos: Los más votados primero / los menos votados primero')));?>
      	<?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
      	<?php if (strpos($order, 'p') === 0):?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
      	<?php endif?>    	
      </th>
      <th class="negative-votes">
      	<?php echo link_to(__('Votos -'), "$route".(!preg_match("/\?/",$route)?'?':'&')."o=".($order=='nd'?'na':'nd'), array('rel'  => 'nofollow', 'title' => __('Ordenar por votos negativos: Los más votados primero / los menos votados primero')));?>
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php if (strpos($order, 'n') === 0):?>
      		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="'.__('descendente').'"':'alt="'.__('ascendente').'"') ?>
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
      <td class="voto"></td>
      <td class="positive-votes">
        <?php echo __('Total:') ?>
    	  <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
    	  <?php echo $totalUp?>
      </td>
      <td class="negative-votes">
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php echo $totalDown?>
      </td>
    </tr>
  </tfoot>

  <tbody>
    <?php foreach($results as $idx => $partido): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="ranking"><?php include_partial('general/sparkline_box', array('reviewable' => $partido, 'id' => 'sparkline_'. $partido->getId())) ?></td>
  	    <td class="position"><?php echo format_number($partidosPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo image_tag(S3Voota::getImagesUrl().'/partidos/cc_s_'.($partido->getImagen()!=''?$partido->getImagen():'p_unknown.png'), 'alt="'. __('Foto de %1%', array('%1%' => $partido)) .'"') ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	$partido->getNombre() . ' (' . $partido->getAbreviatura() . ')', 'partido/show?id='.$partido->getAbreviatura() ); ?>
        </td>
        <td class="voto">
            <?php include_component_slot('quickvote', array('entity' => $partido)) ?>
        </td>
        <td class="positive-votes"><?php echo sumu($partido)?></td>
        <td class="negative-votes"><?php echo sumd($partido)?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $partidosPager, 'url' => "$route".(!preg_match("/\?/",$route)?'?':'&'), 'page_var' => "page", 'order' => $order)) ?>
</p>
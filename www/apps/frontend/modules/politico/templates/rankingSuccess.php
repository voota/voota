<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>
 
<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
  	$("input#ac_partido").autocomplete({
  		source: '<?php echo url_for('politico/acPartido')?>',
  		select: function(event, ui) { $("input#partido").val(ui.item.id); }
  	});
  	$("input#ac_institucion").autocomplete({
  		source: '<?php echo url_for('politico/acInstitucion')?>',
  		select: function(event, ui) { $("input#institucion").val(ui.item.id); }
  	});
  });
  
  $(window).load(function(){
    <?php foreach(($results = $politicosPager->getResults()) as $idx => $politico): ?>
      <?php include_component_slot('sparkline', array('reviewable' => $politico, 'id' => 'sparkline_'. $politico->getId())) ?>
    <?php endforeach ?>
  });
</script>

<h2>
  <?php echo $pageTitle ?>
  
  <?php /* ?>
  <select name="partido" id="partido_selector" class="input">
  <?php foreach ($partidos_arr as $value => $desc): ?>
    <option value="<?php echo $value?>" <?php echo $partido==$value?'selected="selected"':''?>><?php echo $desc?></option>    
  <?php endforeach ?>
  </select>
  <?php */ ?>
</h2>

<form action="<?php echo url_for('politico/ranking')?>">
<input type="hidden" name="p" id="partido" value="all" />
<input type="hidden" name="institucion" id="institucion" />
<p>
	<?php echo __('Buscar políticos')?> <input type="text" id="ac_partido" title="<?php echo __('abreviatura o nombre del partido')?>" />
	<?php echo __('en')?> <input type="text" id="ac_institucion" title="<?php echo __('Parlamento europeo, Gobierno, Congreso...')?>" />
	<input type="submit" value="<?php echo __('Filtrar') ?>" />
</p>
</form>

<?php include_partial('sfReviewFront/dialog') ?>


<?php // include_partial('selectorPartido', array('pageTitle' => $pageTitle, 'partidos_arr' => $partidos_arr, 'favoritos' => $partidos_arr, 'partido' => $partido)) ?>

<?php // include_partial('global/institucionList', array('instituciones' => $instituciones, 'partido' => $partido, 'institucion' => $institucion, 'showPartido' => true)) ?>

<table border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="ranking"></th>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
      	<?php echo link_to(__('Votos +'), "$route".($order=='pd'?(!preg_match("/\?/",$route)?'?':'&')."o=pa":''), array('rel'  => 'nofollow'));?>
      	<?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
      	<?php if (strpos($order, 'p') === 0):?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php endif?>    	
      </th>
      <th class="negative-votes">
      	<?php echo link_to(__('Votos -'), "$route".(!preg_match("/\?/",$route)?'?':'&')."o=".($order=='nd'?'na':'nd'), array('rel'  => 'nofollow'));?>
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
      <td class="voto"></td>
      <td class="positive-votes">
        <?php echo __('Total:') ?>
    	  <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
    	  <?php echo format_number($totalUp, 'es_ES')?>
      </td>
      <td class="negative-votes">
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php echo format_number($totalDown, 'es_ES')?>
      </td>
    </tr>
  </tfoot>

  <tbody>
    <?php foreach($results as $idx => $politico): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="ranking"><?php include_partial('general/sparkline_box', array('reviewable' => $politico, 'id' => 'sparkline_'. $politico->getId())) ?></td>
  	    <td class="position"><?php echo format_number($politicosPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo image_tag(S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $politico)) .'"') ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	cutToLength("".$politico->getNombre() ." ". $politico->getApellidos(), 35) . ($politico->getPartido()?" (" . $politico->getPartido() .")":''), 'politico/show?id='.$politico->getVanity()//. ($partido == 'all'?'':"&partido=$partido"). ($institucion == '0'?'':"&institucion=$institucion")
          ) ?>
        </td>
        <td class="voto">
            <?php include_component_slot('quickvote', array('entity' => $politico)) ?>
        </td>
        <td class="positive-votes"><?php echo sumu($politico)?></td>
        <td class="negative-votes"><?php echo sumd($politico)?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $politicosPager, 'url' => "$route", 'page_var' => "page", 'order' => $order)) ?>
</p>
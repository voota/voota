<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('Number') ?>
<?php use_helper('VoFormat') ?>

<script type="text/javascript">  
  window.onload = function() {
    <?php foreach($propuestasPager->getResults() as $propuesta): ?>
      <?php include_component_slot('sparkline', array('reviewable' => $propuesta, 'id' => 'sparkline_'. $propuesta->getId())) ?>
    <?php endforeach ?>
  };
</script>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function (){
    $('a.tooltip_propuesta').each(function(){
      $(this).qtip({
        content: '<p><strong>' + $(this).attr('title').split('|')[0] + '</strong></p><p>' + $(this).attr('title').split('|')[1] + '</p>',
        position: { corner: { target: 'rightBottom', tooltip_propuesta: 'topMiddle' } },
        style: { name: 'light' }
      });
      $(this).attr('title', '');
    });
  });
</script>

<?php // TODO: Sustituir 358 por el número de propuestas totales ?>
<h2><?php echo __('Ranking de propuestas: de momento %count%', array('%count%' => 358)) ?></h2>

<?php // TODO: Sustituir enlace con URL apropiada ?>
<p><a href="#"><?php echo __('Dar de alta tu propuesta política') ?></a></p>

<table border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="ranking"></th>
      <th class="position"></th>
      <th class="photo"></th>
      <th class="name"><?php echo __('Nombre')?></th>
      <th class="voto"><?php echo __('Voto múltiple')?></th>
      <th class="positive-votes">
        <?php // TODO: Añadir atributo 'title' al enlace, con un texto que describa lo que hace al pulsarse según el caso ?>
        <?php // TODO: Ejemplo: "Ordenar por votos positivos: los que tienen más votos positivos primero" ?>
      	<?php echo link_to(__('Votos +'), "$route".($order=='pd'?(!preg_match("/\?/",$route)?'?':'&')."o=pa":''), array('rel'  => 'nofollow'));?>
      	<?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
      	<?php if (strpos($order, 'p') === 0):?>
      		<?php echo image_tag($order=='pd'?'flechaDown.gif':'flechaUp.gif', $order=='pd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php endif?>    	
      </th>
      <th class="negative-votes">
        <?php // TODO: Añadir atributo 'title' al enlace, con un texto que describa lo que hace al pulsarse según el caso ?>
        <?php // TODO: Ejemplo: "Ordenar por votos positivos: los que tienen más votos positivos primero" ?>
      	<?php echo link_to(__('Votos -'), "$route".(!preg_match("/\?/",$route)?'?':'&')."o=".($order=='nd'?'na':'nd'), array('rel'  => 'nofollow'));?>
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php if (strpos($order, 'n') === 0):?>
      		<?php echo image_tag($order=='nd'?'flechaDown.gif':'flechaUp.gif', $order=='nd'?'alt="descendente"':'alt="ascendente"') ?>
      	<?php endif?>
      </th>
      <th class="date">
        <?php // TODO: Añadir atributo 'title' al enlace, con un texto que describa lo que hace al pulsarse según el caso ?>
        <?php // TODO: Ejemplo: "Ordenar por fecha: las más antiguas primero" ?>
        <?php echo link_to(__('Fecha'), "$route".(!preg_match("/\?/",$route)?'?':'&')."o=".($order=='fd'?'fa':'fd'), array('rel' => 'nofollow'));?>
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
        <?php echo __('Total') ?>
    	  <?php echo image_tag('icoUp20px.gif', 'alt="yeah"') ?>
    	  <?php echo format_number($totalUp, 'es_ES')?>
      </td>
      <td class="negative-votes">
      	<?php echo __('Total')?>
      	<?php echo image_tag('icoDown20px.gif', 'alt="buu"') ?>
      	<?php echo format_number($totalDown, 'es_ES')?>
      </td>
      <td class="date"></td>
    </tr>
  </tfoot>

  <tbody>
    <?php foreach($propuestasPager->getResults() as $idx => $propuesta): ?>
      <tr class="<?php echo fmod($idx, 2) ? 'even' : 'odd' ?>">
  	    <td class="ranking"><?php include_partial('general/sparkline_box', array('reviewable' => $propuesta, 'id' => 'sparkline_'. $propuesta->getId())) ?></td>
  	    <td class="position"><?php echo format_number($propuestasPager->getFirstIndice() + $idx, 'es_ES') ?>.</td>
  	    <td class="photo">
          <?php echo image_tag(S3Voota::getImagesUrl().'/'.$propuesta->getImagePath().'/cc_s_'.$propuesta->getImagen(), 'alt="'. __('Foto de %1%', array('%1%' => $propuesta)) .'"') ?>
  	    </td>
        <td class="name">
          <?php echo link_to(	cutToLength("".$propuesta->getTitulo(), 35), 'propuesta/show?id='.$propuesta->getVanity(), 'class="tooltip_propuesta" title="'.__('Sobre esta propuesta').'|'.cutToLength($propuesta->getDescripcion(), 200, '...', true).'"') ?>
        </td>
        <td class="voto">
            <?php include_component_slot('quickvote', array('entity' => $propuesta)) ?>
        </td>
        <td class="positive-votes"><?php echo sumu($propuesta)?></td>
        <td class="negative-votes"><?php echo sumd($propuesta)?></td>
        <td class="date">
          <?php // TODO: Pintar fecha de la propuesta en formato DD/MM/YYYY ?>
        </td>
      </tr>
    <?php endforeach ?>
  </tbody>  
</table>

<p><a href="<?php echo url_for('propuesta/new')?>"><?php echo __('Dar de alta tu propuesta política') ?></a></p>

<p class="pagination">
  <?php include_partial('global/pagination_full', array('pager' => $propuestasPager, 'url' => "$route", 'page_var' => "page", 'order' => $order)) ?>
</p>

<div class="search">
  <form method="get" action="<?php echo url_for('@search')?>">
    <fieldset>
      <input type="text" name="q" id="q" value="<?php echo $sf_params->get('q') ?>" />
      <button type="submit"><?php echo __('Buscar') ?></button>
    </fieldset>
  </form>
</div>
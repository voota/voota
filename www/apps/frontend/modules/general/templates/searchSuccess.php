<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>

<h2>Resultados</h2>

<?php if ( $res && $res['total_found'] > 0):?>
	<p><?php echo $res['total_found']  == 1?__('%1% resultado encontrado buscando "%2%"', array('%1%' => format_number($res['total_found'], 'es_ES'), '%2%' => $q)):__('%1% resultados encontrados buscando "%2%"', array('%1%' => format_number($res['total_found'], 'es_ES'), '%2%' => $q))?> 
	</p>
<?php endif ?>

<?php if ( $res && $res['total_found'] > 0):?>
  <table border="0" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th class="photo"></th>
        <th class="name"><?php echo __('Nombre')?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($politicosPager->getResults() as $idx => $politico): ?>
        <tr>
          <td class="photo">
            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($politico->getImagen()!=''?$politico->getImagen():'p_unknown.png'), 'alt="Foto de '. $politico->getNombre().' ' . $politico->getApellidos() .'"') ?>
          </td>
          <td class="name">
            <?php echo link_to("".$politico->getNombre() ." ". $politico->getApellidos(), 'politico/show?id='.$politico->getVanity()) ?>
            <?php if ($politico->getPartido()):?> (<?php echo $politico->getPartido() ?>)<?php endif ?>
            <?php if (count($politico->getPoliticoInstitucions()) > 0): ?>, 
      	      <?php foreach ($politico->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php echo $politicoInstitucion->getInstitucion()->getNombre() ?><?php endforeach ?>
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
<?php else: ?>
	<p><?php echo __('No se han encontrado resultados para "%1%".', array('%1%' => $q)) ?></p>
<?php endif ?>

<?php if ( $res && $res['total_found'] > 0):?>
  <p class="pagination">
    <?php include_partial('pagination_full', array('pager' => $politicosPager, 'url' => "@search?q=$q&", 'page_var' => "page")) ?>
  </p>
<?php endif ?>
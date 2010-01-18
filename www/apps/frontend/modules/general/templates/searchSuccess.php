<?php use_helper('I18N') ?>
<?php use_helper('Number') ?>
<?php use_helper('jQuery') ?>

<h2>Resultados</h2>

	<p> 
  	  <?php echo format_number_choice('[0]No se han encontrado resultados para "%2%"|[1]%1% resultado encontrado buscando "%2%"|(1,+Inf]%1% resultados encontrados buscando "%2%"', 
  	  		array('%1%' => format_number($results->getNbResults(), 'es_ES'), '%2%' => $q)
  	  		, $results->getNbResults()) 
  	  ?>
	</p>

<?php if ( $results->getNbResults() > 0):?>
  <table border="0" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th class="photo"></th>
        <th class="name"><?php echo __('Nombre')?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($results->getResults() as $idx => $obj): ?>
        <?php if ($obj instanceof Partido): ?>
	        <tr>
	          <td class="photo">
	            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/partidos/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="Foto de '. $obj .'"') ?>
	          </td>
	          <td class="name">
	            <?php echo link_to("".$obj, 'partido/show?id='.$obj->getAbreviatura()) ?>, <?php echo $obj->getNombre()?>
	          </td>
	        </tr>
        <?php endif ?>
        <?php if ($obj instanceof Institucion): ?>
	        <tr>
	          <td class="photo">
	            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/instituciones/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="Foto de '. $obj .'"') ?>
	          </td>
	          <td class="name">
	            <?php echo link_to($obj->getNombre(), 'politico/ranking?partido=all&institucion='.$obj->getVanity()) ?>
	          </td>
	        </tr>
        <?php endif ?>
        <?php if ($obj instanceof Politico): ?>
	        <tr>
	          <td class="photo">
	            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/politicos/cc_s_'.($obj->getImagen()!=''?$obj->getImagen():'p_unknown.png'), 'alt="Foto de '. $obj->getNombre().' ' . $obj->getApellidos() .'"') ?>
	          </td>
	          <td class="name">
	            <?php echo link_to($obj, 'politico/show?id='.$obj->getVanity()) ?>
	            <?php if ($obj->getPartido()):?> (<?php echo $obj->getPartido() ?>)<?php endif ?>
	            <?php if (count($obj->getPoliticoInstitucions()) > 0): ?>, 
	      	      <?php foreach ($obj->getPoliticoInstitucions() as $idx => $politicoInstitucion): ?><?php if($idx > 0):?>, <?php endif ?><?php echo $politicoInstitucion->getInstitucion()->getNombre() ?><?php endforeach ?>
	            <?php endif ?>
	          </td>
	        </tr>
        <?php endif ?>
        <?php if ($obj instanceof sfGuardUser): ?>
	        <tr>
	          <td class="photo">
	            <?php echo image_tag('http://'.S3Voota::getBucketPub().'.s3.amazonaws.com/usuarios/cc_s_'.($obj->getProfile()->getImagen()!=''?$obj->getProfile()->getImagen():'p_unknown.png'), 'alt="Foto de '. $obj .'"') ?>
	          </td>
	          <td class="name">
	            <?php echo link_to($obj, '@usuario?username='.$obj->getProfile()->getVanity()) ?>, <?php echo $obj->getProfile()->getVanity() ?>
	          </td>
	        </tr>
        <?php endif ?>
      <?php endforeach ?>
      
    </tbody>
  </table>
<?php endif ?>

<?php if ( $res && $res['total_found'] > 0):?>
  <p class="pagination">
    <?php include_partial('global/pagination_full', array('pager' => $results, 'url' => "@search?q=$q&", 'page_var' => "page")) ?>
  </p>
<?php endif ?>
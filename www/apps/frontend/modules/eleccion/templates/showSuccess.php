<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>
<?php use_helper('VoFormat') ?>
<?php use_helper('Date') ?>
<?php use_helper('SfReview') ?>
<?php use_helper('VoUser') ?>

<h2 id="name"><?php echo $convocatoria->getEleccion()->getNombre(); ?>. 
<?php echo __("%dia% de %mes%", array('%dia%' => format_date($convocatoria->getFecha(), ' d'), '%mes%' => format_date($convocatoria->getFecha(), 'MMMM')))?>.</h2>

<div id="content">
  <div title="<?php echo $convocatoria->getEleccion()->getNombre() ?>" id="photo">
  	<?php echo image_tag(S3Voota::getImagesUrl().'/elecciones/cc_'. $convocatoria->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' =>  $convocatoria->getEleccion()->getNombre())) .'"') ?>
  </div>
    
  <div title="info" id="description">
    <?php echo formatPresentacion( $convocatoria->getDescripcion() ) ?>
  </div><!-- end of description -->

  <div class="selector-convocatoria">
    <ul>
      <?php if($geoName):?>
      	<li><a href="<?php echo url_for('eleccion/show?convocatoria='.$convocatoria->getNombre().'&vanity='.$convocatoria->getEleccion()->getVanity())?>"><?php echo $institucionName ?></a></li>
      <?php else:?>
      	<li><span><?php echo $institucionName ?></span></li>
      <?php endif ?>
      <?php foreach ($geos as $geo):?>
        <?php if($geoName && $geo->getNombre() == $geoName):?>
	      <li><span><?php echo $geo->getNombre()?></span></li>
        <?php else:?>
	      <li><a href="<?php echo url_for('eleccion/show?convocatoria='.$convocatoria->getNombre().'&vanity='.$convocatoria->getEleccion()->getVanity().'&geo='.$geo->getNombre())?>"><?php echo $geo->getNombre()?></a></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
  </div>

  <table id="resultados">
    <thead>
      <tr>
        <td class="partido"><?php echo __('Lista') ?></td>
        <td colspan="2"><?php echo __('Escaños según los votos positivos en Voota') ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($partidos as $partido): ?>
          <?php include_component_slot('partido_lista', array('partido' => $partido, 'convocatoria' => $convocatoria, 'geoName' => $geoName, 'minSumu' => $minSumu, 'minSumd' => $minSumd)) ?>
      <?php endforeach ?>
    </tbody>
  </table>

</div><!-- end of content -->


  <?php if(count($activeEnlaces) > 0): ?>
    <div id="external-links">  
      <h3><?php echo __('Enlaces externos')?></h3>
      <ul>
        <?php foreach($activeEnlaces as $enlace): ?>
		      <li><?php echo link_to(toShownUrl(urldecode( $enlace->getUrl() )), toUrl( $enlace->getUrl()) )?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('img.politico').tooltip_politico_elecciones();
  });
</script>
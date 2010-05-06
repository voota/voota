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
  	<?php echo image_tag(S3Voota::getImagesUrl().'/elecciones/cc_'. $convocatoria->getEleccion()->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' =>  $convocatoria->getEleccion()->getNombre())) .'"') ?>
  </div>
    
  <div title="info" id="description">
    <?php echo formatPresentacion( $convocatoria->getEleccion()->getDescripcion() ) ?>
  </div><!-- end of description -->

  <div id="selector_convocatoria">
    <ul>
      <li>Parlament ?!!!!!!!!"???</li>
      <li><a href="#">Barcelona</a></li>
      <li><a href="#">Tarragona</a></li>
      <li><a href="#">Lleida</a></li>
      <li><a href="#">Girona</a></li>
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
      <?php foreach ($listas as $lista): ?>
        <tr>
          <td class="partido"><a href="#"><?php echo $lista->getPartido()->getAbreviatura();?></a></td>
          <td class="escanos">35</td>
          <td class="politicos">
            <?php foreach($lista->getPoliticoListas() as $politicoLista): $politico = $politicoLista->getPolitico(); ?>
              <img class="politico" id="<?php echo "politico_". $politico->getId()?>" src="<?php echo S3Voota::getImagesUrl().'/'.$politico->getImagePath().'/cc_s_'.$politico->getImagen() ?>" alt="<?php echo $politicoLista->getPolitico() ?>" />
              <script type="text/javascript" charset="utf-8">
                $("#<?php echo "politico_". $politico->getId()?>").data('positive_votes', <?php echo $politico->getSumu() ?>);
                $("#<?php echo "politico_". $politico->getId()?>").data('negative_votes', <?php echo $politico->getSumd() ?>);
              </script>
            <?php endforeach ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
    <tfoot>
      <tr>
        <td class="partido"><?php echo __('Mayoría') ?></td>
        <td class="escanos"><?php echo 72 // TODO: Total escaños ?></td>
      </tr>
    </tfoot>
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
<li>
  <div class="photo">
    <?php echo image_tag(S3Voota::getImagesUrl().'/propuestas/cc_s_'.$propuesta->getImagen(), 'alt="'. __('Imagen de %1%', array('%1%' => $propuesta->getTitulo())) .'"') ?>    
  </div>
  <div class="name">
    <strong><?php echo __('Propuesta:') ?></strong>
    <a href="<?php echo url_for('propuesta/show?id='.$propuesta->getVanity()) ?>"><?php echo $propuesta->getTitulo() ?></a>,
    <span class="date"><a href="<?php echo url_for('propuesta/show?id='.$propuesta->getVanity()) ?>"><?php echo ago(strtotime($propuesta->getCreatedAt()))?></a></span>
  </div>
  <div class="actions"><a href="<?php echo url_for('propuesta/show?id='.$propuesta->getVanity()) ?>"><?php echo __('Hacer cambios')?></a></div>
</li>
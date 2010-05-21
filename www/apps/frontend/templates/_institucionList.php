<?php // TODO: Unir con comas, menos la última que va unida con " y " ?>
<?php foreach($instituciones as $i): ?>
  <?php $active = ($i == $institucion ? array('class' => 'active') : null) ?>
  <?php $url = ("partido/ranking?institucion=" . $i->getVanity()); ?>
  <?php echo link_to($i->getNombreCorto(), $url, $active) ?>
<?php endforeach ?>

<?php if (true): //TODO: Mostrar si resultados?>
  <ul>
    <?php foreach ($myTags as $etiqueta): ?>
      <li>
        <a href="<?php echo url_for('general/search?tag='.$etiqueta)?>"><?php echo $etiqueta ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
        <a href="#" class="remove" onclick="return removeTag(<?php echo $etiqueta->getId()?>)">X</a>
      </li>
    <?php endforeach ?>
    
	<?php include_component_slot('tagList', array('entity' => $entity)) ?>
    
  </ul>
<?php else: ?>
  <p><?php echo __('Aún no ha sido etiquetado') ?></p>
<?php endif ?>


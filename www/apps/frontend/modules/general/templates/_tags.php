<?php use_helper('I18N') ?>

<?php if (count($myTags) > 0 || $allTagsPager->getNbResults() > 0): ?>
  <ul>
    <?php foreach ($myTags as $etiqueta): ?>
      <li class="review">
        <a href="<?php echo url_for('general/search?tag='.armorTag( $etiqueta ))?>"><?php echo $etiqueta ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
        <a href="#" class="remove" onclick="return removeTag(<?php echo $etiqueta->getId()?>)">X</a>
      </li>
    <?php endforeach ?>
    
	<?php include_component_slot('tagList', array('entity' => $entity, 'myCount' => count($myTags))) ?>
    
  </ul>
<?php else: ?>
  <p><?php echo __('De momento sin etiquetas') ?></p>
<?php endif ?>


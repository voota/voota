
<?php if ($myTags || $allTags): ?>
  <ul>
    <?php foreach ($myTags as $etiqueta): ?>
      <li>
        <a href="#"><?php echo $etiqueta // TODO: Enlazar a página de etiqueta ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
        <a href="#" class="remove" onclick="return removeTag(<?php echo $etiqueta->getId()?>)">X</a>
      </li>
    <?php endforeach ?>
    <?php foreach ($allTags as $etiqueta): ?>
      <li>
        <a href="#"><?php echo $etiqueta // TODO: Enlazar a página de etiqueta ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
      </li>
    <?php endforeach ?>
  </ul>
<?php else: ?>
  <p><?php echo __('Aún no ha sido etiquetado') ?></p>
<?php endif ?>
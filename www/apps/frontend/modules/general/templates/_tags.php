<?php if ($myTags || $allTags): ?>
  <ul>
    <?php foreach ($myTags as $etiqueta): ?>
      <li>
        <a href="#"><?php echo $etiqueta // TODO: Enlazar a página de etiqueta ?></a>
        <?php echo "(".$etiqueta->getCount().")" ?>
        <a href="" class="remove">X</a> <?php // TODO: Enlazar a eliminación de voto a esa etiqueta del usuario actual ?>
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
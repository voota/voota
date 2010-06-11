<?php use_helper('I18N') ?>
<?php use_helper('jQuery') ?>

<?php // TODO: La variable $entity contiene el político, partido o propuesta ?>

<?php if (true): // TODO: Si hay etiquetas ?>
  <ul>
    <?php foreach (array("Desgraciao", "Educado", "Cumplidor") as $etiqueta): // TODO: Cargar etiquetas reales ?>
      <li>
        <a href="#"><?php echo $etiqueta // TODO: Enlazar a página de etiqueta ?></a>
        <?php echo "(2)" // TODO: Contador de apariciones de etiqueta ?>
        <?php if (true): // TODO: Si el usuario actual escribió esta etiqueta ?>
          <a href="" class="remove">X</a> <?php // TODO: Enlazar a eliminación de voto a esa etiqueta del usuario actual ?>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
<?php else: ?>
  <p><?php echo __('Aún no ha sido etiquetado') ?></p>
<?php endif ?>
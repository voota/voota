<?php use_helper('I18N') ?>

<h2><?php echo __('Normas de publicación en Voota')?></h2>

<div id="content">
  <h3 id="summary">
    <?php echo __('En pocas palabras ...') ?>
    <br />
    <?php echo __('Las opiniones son libres, publica todo lo que quieras, a favor o en contra, salvo lo que esté prohibido por ley.') ?>
  </h3>

  <h3><?php echo __('¿Qué es lo que está prohibido por ley? (ojo, lista no exhaustiva)') ?></h3>
  <ul>
    <li><?php echo __('Publicar datos personales de terceros (políticos u otros usuarios)') ?></li>
    <li><?php echo __('Insultar o amenazar.') ?></li>
    <li><?php echo __('Incitar al odio, la violencia o la difamación.') ?></li>
    <li><?php echo __('Incitar a la discriminación por razones de sexo, raza, religión, afiliación, política, creencias, edad o condición.') ?></li>
    <li><?php echo __('Enlazar a páginas con contenidos ilegales.') ?></li>
    <li><?php echo __('Incluir contenidos protegidos por derechos de propiedad de terceros sin autorización.') ?></li>
  </ul>

  <p>
    <?php echo __('¿Más detalles?') ?>
    <?php echo link_to(__('Date una vuelta por nuestro aviso legal'), __('http://blog.voota.es/es/aviso-legal')) ?>
  </p>

  <p>
    <strong><?php echo __('Ayúdanos a mejorar Voota') ?>:</strong>
    <?php echo link_to(__('Contáctanos si ves algún contenido ilegal'), "@contact")?>
  </p>
</div>

<div id="sidebar">
  <?php include_partial('socialBox') ?>
</div>
<?php use_helper('I18N') ?>

<h2><?php echo __('Contacta con Voota') ?></h2>
<p class="success-msg"><?php echo __('Gracias por tu mensaje') ?></p>

<div id="content">
  <p class="next-step-msg"><?php echo __('¿Que hacemos ahora?') ?> <?php echo __('Tú dirás.') ?></p>
  <p class="next-step-msg"><?php echo __('¿Nos vamos a la')?> <?php echo link_to("home de Voota", "@homepage") ?>?</p>
  <p class="next-step-msg"><?php echo __('¿Una vuelta por el')?> <?php echo link_to(__("ranking de políticos"), "politico/ranking") ?> <?php echo __('quizás?') ?></p>
</div>

<div id="sidebar">
  <?php include_partial('socialBox') ?>
</div>